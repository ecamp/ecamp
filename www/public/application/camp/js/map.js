/*
 * Copyright (C) 2010 Urban Suppiger, Pirmin Mattmann
 *
 * This file is part of eCamp.
 *
 * eCamp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * eCamp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with eCamp.  If not, see <http://www.gnu.org/licenses/>.
 */

// $Id: it.js 26083 2008-11-11 12:10:56Z tbruederli $
function CED(txt) {
    var element = document.getElementById('jsdebug');
    if (element)
        element.innerHTML = txt ? txt : "";
}

function ED() {
    var element = document.getElementById('jsdebug');
    if (element) {
        var text = "";
        for (var i = 0; i < arguments.length; i++) {
            var variable = arguments[i];
            if (typeof variable == "string")
                variable = variable.replace(/&/g, '&amp;').replace(/</g, '&lt;');
            text += (typeof variable) + " " + variable;
            if (typeof variable == "object") {
                text += ":";
                for (field in variable) {
                    text += field + "=";
                    try {
                        text += typeof variable[field] == 'function' ? 'function' : variable[field];
                    } catch (e) {
                        text += "*" + e + "*";
                    }
                    text += "\n";
                }
                text += "\n";
            }
            text += "\n";
        }
        element.innerHTML += '<pre style="background-color:#FEE; margin:0">' + text + '</pre>';
    }
}

function Q(value) {
    return typeof value == "undefined" ? "" : value.toString().replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

String.prototype.T = function (values) {
    var result = this;
    for (key in values)
        result = result.replace(new RegExp("{" + key + "}", "g"), values[key]);
    return result;
}

function it_event(p) {
    var oldhandler = p.element["on" + p.event];
    p.element["on" + p.event] = function (ev) {
        var pp = arguments.callee.p ? arguments.callee.p : p;
        var oo = arguments.callee.oldhandler ? arguments.callee.oldhandler : oldhandler;
        var result = pp.object[pp.method](ev ? ev : window.event, pp);
        if (result && oo)
            result = oo(ev);
        return result;
    }
    p.element["on" + p.event].p = p;
    p.element["on" + p.event].oldhandler = oldhandler;
}

function it_get_obj_x(obj) {
    var curleft = 0;
    if (obj.offsetParent)
        while (obj) {
            curleft += obj.offsetLeft;
            obj = obj.offsetParent;
        }
    else if (obj.x)
        curleft += obj.x;
    return curleft;
}

function it_get_obj_y(obj) {
    var curtop = 0;
    if (obj.offsetParent)
        while (obj) {
            curtop += obj.offsetTop;
            obj = obj.offsetParent;
        }
    else if (obj.y)
        curtop += obj.y;
    return curtop;
}

function it_find_obj(obj) {
    if (document.getElementById)
        return document.getElementById(obj);
    else if (document.all)
        return document.all[obj];
    else if (document.layers)
        return document.layers[obj];
    return null;
}

function it_element(label) {
    var tmp = it_find_obj(label);
    return tmp ? tmp : {style: {}, src: "", value: "", isundefined: true};
}

function it_get_iframe_document(iframe) {
    return iframe.contentWindow ? iframe.contentWindow.document : iframe.contentDocument;
}

function it_create_element(doc, type, init) {
    var e = document.createElement(type);
    it_set(e, init);
    doc.appendChild(e);
    return e;
}

function it_set(dst, src) {
    if (dst) {
        for (var i in src) {
            if (typeof src[i] == 'object') {
                if (dst[i])
                    it_set(dst[i], src[i]);
            } else
                dst[i] = src[i];
        }
    }
}

function it_now() {
    return new Date().getTime();
}

function it_url_encode(str) {
    var result = window.encodeURIComponent ? encodeURIComponent(str) : escape(str).replace(/\+/g, "%2B");
    return result.replace(/%20/gi, "+").replace(/%2C/gi, ",").replace(/%3B/gi, ";").replace(/%28/gi, "(").replace(/%29/gi, ")");
}

function it_pngfix(img, w, h, mode) {
    var old_IE = navigator.platform == "Win32" && String(navigator.userAgent).match(/MSIE ((5\.5)|6)/);
    if (img.src && img.src.match(/\.png($|\?)/) && old_IE) {
        img.style.width = (w || img.width) + 'px';
        img.style.height = (h || img.height) + 'px';
        img.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + img.src + "',sizingMethod='" + (mode ? mode : 'crop') + "')";
        img.src = '/images/0.gif';
    } else if (img && old_IE)
        img.style.filter = 'none';
}

function it_http(cb) {
    this.instance = it_http.instances++;
    this.callback = cb ? cb : {};
    this.req = null;
    this.scrpt = [];
    this.callid = 0;
    this.busy = false;
    it_http['__inst' + this.instance] = this;
}

it_http.prototype = {
    get: function (url, callback) {
        if (typeof callback != 'undefined')
            this.callback = callback;
        this.send(url, 'GET');
    },
    post: function (url, data, callback) {
        if (typeof callback != 'undefined')
            this.callback = callback;
        var postdata = '';
        if (typeof data == 'object') {
            for (var k in data)
                postdata += (postdata ? '&' : '') + it_url_encode(k) + "=" + it_url_encode(data[k]);
        } else
            postdata = data;
        this.send(url, 'POST', postdata);
    },
    send: function (url, method, postdata) {
        this.stop();
        this.busy = true;
        this.req = null;
        var samehost = (url.indexOf('http://') < 0 || url.indexOf(window.location.hostname) > 0);
        if (samehost) {
            try {
                this.req = new XMLHttpRequest();
            } catch (e) {
                var classnames = ['MSXML2.XMLHTTP', 'Microsoft.XMLHTTP'];
                for (var i = 0; i < classnames.length; i++) {
                    try {
                        this.req = new ActiveXObject(classnames[i]);
                        break;
                    } catch (e) {
                    }
                }
            }
            try {
                this.req.open(method, url);
                var me = this;
                this.req.onreadystatechange = function () {
                    me.ready_state_changed();
                }
                var workingxmlhttp = this.req.onreadystatechange;
                if (!workingxmlhttp)
                    this.req = null;
            } catch (e) {
            }
        }
        this.starttime = new Date().getTime();
        if (this.req) {
            if (method == "POST")
                this.req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            this.req.send(postdata);
        } else {
            url += (url.match(/\?/) ? "&" : "?") + "itjs_call=it_http.__inst" + this.instance + "&itjs_callid=" + (++this.callid) + (postdata ? '&' + postdata : "");
            if (samehost || (window.opera && !window.XMLHttpRequest)) {
                var scrpt = document.createElement("iframe");
                scrpt.style.width = scrpt.style.height = 1;
                url += "&itjs_iframe=1";
            } else {
                var scrpt = document.createElement("script");
                this.req = {starttime: this.starttime};
                try {
                    this.scrpt[this.callid] = scrpt;
                    if (!document.all) scrpt.src = url;
                    document.body.appendChild(scrpt);
                    if (document.all) scrpt.src = url;
                } catch (e) {
                    return false;
                }
            }
        }
        return true;
    },
    ready_state_changed: function () {
        var req = this.req;
        if (req && (req.readyState == 4)) {
            var data = null;
            try {
                if (req.responseText != "")
                    data = eval("(" + req.responseText + ")");
            } catch (e) {
                if (typeof this.callback == 'object' && this.callback.errorhandler) {
                    var obj = this.callback.object ? this.callback.object : window;
                    if (typeof obj[this.callback.errorhandler] == 'function')
                        obj[this.callback.errorhandler](req.responseText);
                } else
                    ED(e, req.responseText);
            }
            if (data)
                this.dataReady(data, this.callid);
            this.unlink(this.callid);
        }
    },
    dataReady: function (data, callid) {
        var fixkonqueror33gcbug = this.req;
        var loadtime = new Date().getTime() - this.starttime;
        this.req = null;
        if ((typeof data == "object") && (this.callid == callid)) {
            data.loadtime = loadtime;
            if (typeof this.callback == 'function')
                this.callback(data);
            else if (typeof this.callback == 'object' && this.callback.method) {
                var obj = this.callback.object ? this.callback.object : window;
                if (typeof obj[this.callback.method] == 'function')
                    obj[this.callback.method](data);
            }
        }
    },
    stop: function () {
        try {
            this.req.abort();
        } catch (e) {
        }
        this.unlink(this.callid);
    },
    unlink: function (callid) {
        if (this.req)
            this.req = null;
        if (this.scrpt[callid]) {
            if (!(document.all && String(navigator.userAgent).indexOf('MSIE 5.0') > 0))
                document.body.removeChild(this.scrpt[callid]);
            this.scrpt[callid] = null;
        }
        this.busy = false;
    }
}
it_http.instances = 0;
it_http.get_instance = function () {
    var inst;
    for (var i = 0; i < it_http.instances; i++)
        if ((inst = it_http['__inst' + i]) && inst.pub && !inst.busy)
            return inst;
    inst = new it_http();
    inst.pub = true;
    return inst;
}
it_http.get = function (url, callback) {
    var inst = it_http.get_instance();
    inst.callback = callback;
    inst.get(url);
}
it_http.post = function (url, postdata, callback) {
    var inst = it_http.get_instance();
    inst.callback = callback;
    inst.post(url, postdata);
}

function it_loader(handler) {
    this.http = null;
    this.handler = handler;
    this.callback = {object: this, method: 'dataReady', errorhandler: 'onerror'};
    this.clear();
}

it_loader.prototype =
    {
        clear: function () {
            this.entry = new Array();
            this.start = this.end = 0;
            this.attr = {num: 0, loadtime: 0};
            if (this.handler.clear)
                this.handler.clear();
        },
        load: function (baseurl, pos, num, query_volatile, retry) {
            pos -= 0;
            num -= 0;
            if (isNaN(retry))
                retry = 0;
            if (baseurl != this.baseurl) {
                this.clear();
                this.baseurl = baseurl;
                this.start = this.end = pos;
            }
            this.pos = pos;
            this.num = num;
            this.query_volatile = query_volatile;
            this.stop();
            while ((num > 0) && (typeof this.entry[pos] != "undefined")) {
                pos++;
                num--;
            }
            if (this.attr.eof)
                num = Math.min(num, this.end - pos);
            if (num > 0) {
                this.retry = retry;
                this.http = it_http.get_instance();
                this.http.get(baseurl + (baseurl.match(/\?/) ? "&" : "?") + "pos=" + pos + "&num=" + num + (retry ? "&retry=" + retry : "") + (query_volatile ? query_volatile : ""), this.callback);
            } else
                this.handler.render(this);
            return true;
        },
        post: function (baseurl, data) {
            this.clear();
            this.http = it_http.get_instance();
            this.http.post(baseurl, data, this.callback);
        },
        retryload: function (p) {
            this.load(p.baseurl, p.pos, p.num, p.query_volatile, p.retry);
        },
        dataReady: function (data) {
            if ((typeof data == "object")) {
                this.attr = {};
                for (var key in data) {
                    var value = data[key];
                    var id = key - 0;
                    if (!isNaN(id)) {
                        this.start = Math.min(this.start, id);
                        this.end = Math.max(this.end, id + 1);
                        this.entry[id] = data[key];
                    } else
                        this.attr[key] = data[key];
                }
                if (this.attr.eof)
                    this.attr.num = this.end;
                this.handler.render(this);
                if (!this.attr.eof && (this.end < this.pos + this.num))
                    this.load(this.baseurl, this.end, this.pos + this.num - this.end);
                it_loader.sequence += "h";
                this.http = null;
            }
        },
        onerror: function (response) {
            var retry = this.retry + 1;
            if (retry < 10)
                it_timer({
                    object: this,
                    method: "retryload",
                    timeout: Math.pow(5, Math.min(retry, 5)),
                    baseurl: this.baseurl,
                    pos: this.pos,
                    num: this.num,
                    query_volatile: this.query_volatile,
                    retry: retry
                });
            else
                ED(response);
        },
        stop: function () {
            if (this.http)
                this.http.stop();
        }
    }
it_loader.sequence = "";
var it_state =
    {
        it_iframe: null,
        it_history_field: null,
        it_state_saved: false,
        it_store_handlers: [],
        it_restore_handlers: [],
        register_store_handler: function (p) {
            this.it_store_handlers[this.it_store_handlers.length] = p;
        },
        register_restore_handler: function (p) {
            this.it_restore_handlers[this.it_restore_handlers.length] = p;
            if (this.it_history_field && this.it_history_field.value)
                p.object[p.method]();
        },
        new_history_entry: function (p) {
            this.store_state();
            this.it_state_saved = true;
            if (!this.it_iframe && !(this.it_iframe = document.getElementById('it_state')))
                ED('it_state::new_history_entry(): it_state object not found!');
            var idoc;
            if ((idoc = it_get_iframe_document(this.it_iframe))) {
                idoc.title = document.title;
                idoc.forms[0].submit();
            }
            this.it_history_field = null;
        },
        restore_history: function () {
            if (!this.it_iframe && !(this.it_iframe = document.getElementById('it_state')))
                ED('it_state::restore_history(): it_state object not found!');
            var idoc = it_get_iframe_document(this.it_iframe);
            this.it_history_field = idoc ? idoc.getElementById('state') : {};
            this.it_state_saved = false;
            if (this.it_history_field.value) {
                var res = eval('({' + this.it_history_field.value + '})');
                for (var key in res)
                    this[key] = res[key];
            }
            for (var i in this.it_restore_handlers) {
                if (this.it_history_field.value || (this.it_restore_handlers[i].initial && (!idoc || !idoc.location.href.match(/s=/))))
                    this.it_restore_handlers[i].object[this.it_restore_handlers[i].method]();
            }
        },
        store_state: function () {
            if (!this.it_iframe && !(this.it_iframe = document.getElementById('it_state')))
                ED('it_state::store_state(): it_state object not found!');
            var idoc = it_get_iframe_document(this.it_iframe);
            this.it_history_field = idoc ? idoc.getElementById('state') : {};
            for (var i in this.it_store_handlers)
                this.it_store_handlers[i].object[this.it_store_handlers[i].method]();
            var ser = [];
            for (var key in this) {
                var value = this[key], type = typeof (value);
                if (!key.match(/^it_/) && type.match(/boolean|number|string/))
                    ser[ser.length] = key + ':' + ((type == 'string') ? "'" + value.replace(/([\\'])/g, '\\\1') + "'" : value);
            }
            this.it_history_field.value = ser.join(',');
        }
    }

function it_state_restore_history() {
    it_state.restore_history();
}

function it_timer(p) {
    this.func = p.continuous ? "Interval" : "Timeout";
    return this.timer = window["set" + this.func](function () {
        p.object[p.method](p)
    }, p.timeout);
}

it_timer.prototype =
    {
        stop: function () {
            if (this.timer) {
                window["clear" + this.func](this.timer);
                this.timer = null;
            }
        }
    }

function it_timerlog(label, print) {
    if (window.it_timerlog_active) {
        var end = new Date().getTime();
        if (typeof window.it_timernow != "undefined") {
            var start = window.it_timernow;
            if (window.it_timerlogmsg != "")
                window.it_timerlogmsg += ", ";
            window.it_timerlogmsg += label + ":" + (end - start);
        } else
            window.it_timerlogmsg = "";
        window.it_timernow = end;
        if (print) {
            ED("timerlog: " + window.it_timerlogmsg);
            window.it_timerlogmsg = "";
        }
    }
}

it_timerlog("");

function it_extend(subclass, superclass) {
    function Dummy() {
    }

    Dummy.prototype = superclass.prototype;
    subclass.prototype = new Dummy();
    subclass.prototype.constructor = subclass;
    subclass.superclass = superclass;
    subclass.superproto = superclass.prototype;
}

function it_add_event(p) {
    if (!p.object || !p.method)
        return;
    if (!p.element)
        p.element = document;
    if (!p.object._it_events)
        p.object._it_events = [];
    var evt = p.event;
    var key = p.event + '*' + p.method;
    var p_closure = p;
    if (!p.object._it_events[key])
        p.object._it_events[key] = function (e) {
            return p_closure.object[p_closure.method](e, p_closure);
        };
    if (p.element.addEventListener)
        p.element.addEventListener(evt, p.object._it_events[key], false);
    else if (p.element.attachEvent)
        p.element.attachEvent('on' + evt, p.object._it_events[key]);
    else {
        p.element['on' + evt] = function (e) {
            var ret = true;
            for (var k in p_closure.object._it_events)
                if (p_closure.object._it_events[k] && k.indexOf(evt) == 0)
                    ret = p_closure.object._it_events[k](e);
            return ret;
        };
    }
}

function it_remove_event(p) {
    if (!p.element)
        p.element = document;
    var key = p.event + '*' + p.method;
    if (p.object && p.object._it_events && p.object._it_events[key]) {
        if (p.element.removeEventListener)
            p.element.removeEventListener(p.event, p.object._it_events[key], false);
        else if (p.element.detachEvent)
            p.element.detachEvent('on' + p.event, p.object._it_events[key]);
        p.object._it_events[key] = null;
    }
}

function it_event_void(evt) {
    var e = evt ? evt : window.event;
    if (e.preventDefault)
        e.preventDefault();
    if (e.stopPropagation)
        e.stopPropagation();
    e.cancelBubble = true;
    e.returnValue = false;
    return false;
}

function it_array_flip(a) {
    var out = {};
    for (var k in a)
        out[a[k]] = k;
    return out;
}

function it_array_keys(a) {
    var out = [];
    for (var k in a)
        if (a[k])
            out[out.length] = k;
    return out;
}

function it_rel_obj_pos(obj, ref) {
    var curtop = 0;
    var curleft = 0;
    if (obj.offsetParent)
        while (obj && obj != ref) {
            curleft += obj.offsetLeft;
            curtop += obj.offsetTop;
            obj = obj.offsetParent;
        }
    else if (obj.x) {
        curleft += obj.x;
        curtop += obj.y;
    }
    return [curleft, curtop];
}

var it_dom = {
    _elem: function (a) {
        return typeof (a) == 'object' && a.style ? a : it_element(a);
    },
    set_class: function (element, value) {
        it_dom._elem(element).className = value;
    },
    set_style: function (element, prop, value) {
        it_dom._elem(element).style[prop] = value;
    },
    set_z: function (element, z) {
        element = it_dom._elem(element);
        element.style.zIndex = z;
    },
    moveto: function (element, x, y) {
        element = it_dom._elem(element);
        element.style.left = Math.round(x) + 'px';
        element.style.top = Math.round(y) + 'px';
    },
    moveby: function (element, dx, dy) {
        element = it_dom._elem(element);
        element.style.left = Math.round(element.offsetLeft + dx) + 'px';
        element.style.top = Math.round(element.offsetTop + dy) + 'px';
    },
    resizeto: function (element, w, h) {
        element = it_dom._elem(element);
        if (w !== null)
            element.style.width = Math.round(w) + 'px';
        if (h !== null)
            element.style.height = Math.round(h) + 'px';
    },
    display: function (element, mode) {
        element = it_dom._elem(element);
        var isie = document.all && !window.opera;
        if (!mode) element.style.display = 'none';
        else element.style.display = isie ? 'block' : (element.nodeName == 'TABLE' ? 'table' : (element.nodeName == 'TR' ? 'table-row' : (element.nodeName == 'TD' ? 'table-cell' : 'block')));
    },
    show: function (element) {
        it_dom.set_style(element, 'visibility', 'inherit');
    },
    hide: function (element) {
        it_dom.set_style(element, 'visibility', 'hidden');
    },
    computed_style: function (elm, prop, mze) {
        if (arguments.length == 2)
            mze = prop;
        var el = elm;
        if (typeof (elm) == 'string')
            el = elem(elm);
        var val = false;
        try {
            if (el && el.currentStyle)
                val = el.currentStyle[prop];
            else if (el && document.defaultView && document.defaultView.getComputedStyle)
                val = document.defaultView.getComputedStyle(el, null).getPropertyValue(mze);
        } catch (e) {
            if (el)
                val = el.style[prop];
        }
        return val;
    }
};

function search_get_event(e) {
    return e ? e : window.event;
}

function search_check_event(ev, elemId) {
    var elem;
    if (ev.srcElement && typeof ev.srcElement != "undefined")
        elem = ev.srcElement;
    else if (ev.target && typeof ev.target != "undefined")
        elem = ev.target;
    return (elem.id && elem.id == elemId) ? true : false;
}

function search_get_target(e) {
    var t;
    if (!e)
        e = window.event;
    if (e.target)
        t = e.target;
    else if (e.srcElement)
        t = e.srcElement;
    if (t && t.nodeType == 3)
        t = t.parentNode;
    return t;
}

function search_mouse_pos(e) {
    var ev = search_get_event(e);
    if (typeof ev.pageX != "undefined")
        return [ev.pageX, ev.pageY];
    else if (typeof ev.clientX != "undefined")
        return [ev.clientX + document.body.scrollLeft + document.documentElement.scrollLeft,
            ev.clientY + document.body.scrollTop + document.documentElement.scrollTop];
    else
        return [0, 0];
}

function search_rel_mouse_pos(e) {
    var ev = search_get_event(e);
    if (typeof ev.layerX != "undefined")
        return [ev.layerX, ev.layerY];
    else if (typeof ev.offsetX != "undefined")
        return [ev.offsetX, ev.offsetY];
    else
        return search_mouse_pos(e);
}

function search_client_size() {
    if (self.innerHeight)
        return [self.innerWidth, self.innerHeight];
    else if (document.documentElement && document.documentElement.clientHeight)
        return [document.documentElement.clientWidth, document.documentElement.clientHeight];
    else if (document.body && document.body.clientHeight)
        return [document.body.clientWidth, document.body.clientHeight];
    else
        return [800, 600];
}

function search_scroll_offset() {
    var pagex = window.scrollX;
    var pagey = window.scrollY;
    if (window.pageXOffset)
        pagex = window.pageXOffset;
    else if (document.documentElement && document.documentElement.scrollLeft)
        pagex = document.documentElement.scrollLeft;
    else if (document.body)
        pagex = document.body.scrollLeft;
    if (window.pageYOffset)
        pagey = window.pageYOffset;
    else if (document.documentElement && document.documentElement.scrollTop)
        pagey = document.documentElement.scrollTop;
    else if (document.body)
        pagey = document.body.scrollTop;
    return [pagex, pagey];
}

function search_unfocus(o) {
    if (o.blur)
        o.blur();
}

function search_win(url, w, h, name, features) {
    var wi, f = features ? features : 'status=yes,scrollbars=yes,resizable=yes';
    if ((wi = window.open(url, name, f + ',width=' + w + ',height=' + h)))
        setTimeout(function () {
            try {
                wi.focus();
            } catch (ex) {
            }
        }, 20);
    return wi;
}

function search_user_agent() {
    var ua = window.navigator && navigator.userAgent ? navigator.userAgent : "";
    var version = window.navigator ? navigator.appVersion : "";
    var platform = String(navigator.platform).toLowerCase();
    this.ie = document.all && !window.opera && version.match(/MSIE ([0-9.]+)/) ? parseFloat(RegExp.$1) : false;
    this.ie5 = this.ie >= 5 && this.ie < 5.5;
    this.ie7 = this.ie >= 7;
    this.iemac = ua.match(/MSIE.*Mac/) && !window.opera;
    this.safari = ua.match(/(safari|applewebkit)\/(\d+)/i) ? parseInt(RegExp.$2) : false;
    this.opera = ua.match(/opera.(\d+)/i) ? parseInt(RegExp.$1) : false;
    this.konqueror = ua.match(/Konqueror\/(\d+\.\d+)/) ? parseFloat(RegExp.$1) : false;
    this.gecko = ua.match(/rv:(\d\.\d+)/i) ? parseFloat(RegExp.$1) : false;
    this.oldgecko = (this.gecko && this.gecko < 1.8);
    this.iphone = this.safari && ua.match(/iPhone/) ? (this.safari >= 525 ? 2 : 1) : false;
    this.win = (platform.indexOf('win') >= 0);
    this.win2k = ua.match(/NT 5\.0/);
    this.mac = (platform.indexOf('mac') >= 0);
    this.x11 = (ua.indexOf('X11') > 0 || platform.indexOf('linux') >= 0 || platform.indexOf('unix') >= 0);
    this.lang = (this.ie ? navigator.browserLanguage : navigator.language).substring(0, 2);
    this.dom = (document.createElement && document.documentElement) ? true : false;
    this.dom2 = (document.addEventListener && document.removeEventListener) ? true : false;
    this.vectors = (this.gecko >= 1.8 || this.safari >= 412 || this.opera >= 9 || (this.ie && window.G_vmlCanvasManager));
    this.pngalpha = (this.gecko || this.opera >= 6 || this.ie >= 5.5 || this.safari) ? true : false;
    this.it_state = !this.opera && !this.iemac;
}

function SearchChEvent() {
    this._events = {};
}

SearchChEvent.prototype = {
    addEventListener: function (evt, func, obj) {
        if (!this._events)
            this._events = {};
        if (!this._events[evt])
            this._events[evt] = [];
        var e = {func: func, obj: obj ? obj : window};
        this._events[evt][this._events[evt].length] = e;
    },
    removeEventListener: function (evt, func, obj) {
        if (typeof obj == 'undefined')
            obj = window;
        for (var h, i = 0; this._events && this._events[evt] && i < this._events[evt].length; i++)
            if ((h = this._events[evt][i]) && h.func == func && h.obj == obj)
                this._events[evt][i] = null;
    },
    triggerEvent: function (evt, e) {
        var ret, h;
        if (typeof e == 'undefined')
            e = {};
        e.event = evt;
        if (this._events && this._events[evt] && !this._event_exec) {
            this._event_exec = true;
            for (var i = 0; i < this._events[evt].length; i++) {
                if ((h = this._events[evt][i])) {
                    if (typeof h.func == 'function')
                        ret = h.func.call ? h.func.call(h.obj, e) : h.func(e);
                    else if (typeof h.obj[h.func] == 'function')
                        ret = h.obj[h.func](e);
                    if (typeof ret != 'undefined' && !ret)
                        break;
                }
            }
        }
        this._event_exec = false;
        return ret || typeof ret == 'undefined';
    }
}

function SearchChMap(p) {
    this.mapcontainer = "mapcontainer";
    this.type = "aerial";
    this.base = "";
    this.poilist = this.env.poilist;
    this.base_corr = this.env.base_corr;
    this.contextmenu_default = [
        {label: this.env.text.zoomout, object: this, method: "zoom", param: -1, disabled: "contextmenu_zoomdisabled"}
    ];
    this.useragent = new search_user_agent();
    this.p = {
        center: "",
        autoresize: true,
        autoload: true,
        circle: true,
        enable: (this.useragent.iphone ? 'dragging,clickpoi' : 'dragging,clickzoom,pois'),
        nocss: false
    };
    this.id = SearchChMap.instances.length;
    this.dom_id_prefix = 'smap' + this.id + '_';
    this.ref = 'SearchChMap.instances[' + this.id + ']';
    this._events = {};
    this.charset = document.characterSet ? document.characterSet.toUpperCase() : String(document.charset).toUpperCase();
    this.ready = this.busy = this.loaded = this.is_error = false;
    this.mapw = this.maph = 0;
    this.maptop = this.mapleft = 0;
    this.centerx = this.centery = 0;
    if (this.useragent.opera)
        this.charset = 'ISO-8859-1';
    this.default_z = 1;
    this.base_url = "/";
    this.coord_base = "";
    this.bandwidth = "high";
    this.default_bandwidth = this.useragent.iphone || location.host.match('route') ? "low" : "high";
    this.show_circle = false;
    this.transform = this.env.transform;
    this.dozoom_timer = this.load_control_timer = this.change_check_timer = 0;
    this.dragpoll_timer = this.pan_timer = this.fade_timer = 0;
    this.zi = 0;
    this.mode = "";
    this.popup = this.popup_bar = 0;
    this.startuptimestamp = window.it_starttime ? it_starttime : it_now();
    this.drag_limit = 16;
    this.drag_timeout = 500;
    this.drag_distance = this.drag_start_time = this.drag_started = 0;
    this.screenx = this.screeny = this.prevx = this.prevy = 0;
    this.map_mouseinside = false;
    this.startx = this.starty = this.vx = this.vy = this.starttime = 0;
    this.pressed = [];
    this.poi = "";
    this.poi_sticky = false;
    this.poi_wannaload = this.poi_requested = this.poi_unpacked = this.poi_unpacked_url = this.poi_shown = "";
    this.poi_packed = {foo: 'bar'};
    this.mousex = this.mousey = this.poi_mousex = this.poi_mousey = 9999;
    this.poi_mouset = this.poi_oldmousex = this.poi_oldmousey = this.poi_oldmouset = this.poi_speed = 0;
    this.dynpois = {};
    this.showing_dyn_poi = 0;
    this.popup_poi = this.popup_showtime = this.popup_checkposx = this.popup_checkposy = "";
    this.popup_maxwidth = this.popup_maxheight = 0.8;
    this.loader = new it_loader(this);
    this.geocoder = new GeoCoder(this, true);
    this.tt = null;
    this.dbl_offset = this.preload_count = this.show_loading_timeout = this.switch_hard = 0;
    this.topx = this.topy = this.tilew = this.tileh = this.ztilew = this.ztileh = this.boxleft = this.boxright = this.boxtop = this.boxbottom;
    this.zl_adj = {bg: [], sym: []};
    this.hslayer = false;
    this.currentclipping = {};
    this.img = [];
    this.circle_img = {};
    this.circle_offset = [0, 0];
    this.ping_img = this.loading_img = false;
    this.panspeed = 0.2;
    this.zoomtime = 600;
    this.zoommovex = this.zoommovey = this.zoomtargetlevel = 0;
    this.s_centerx = this.s_centery = 1;
    this.s_check = false;
    this.lastping = this.lastactivity = 0;
    this.x11factor = this.useragent.x11 ? 3 : 1;
    this.fade_obj_shown = 0;
    this.fade_obj_vis = false;
    this.fade_obj = this.fade_start = 0;
    this.fade_length = 250;
    this.fade_dir = "in";
    this.fade_max = 0.8;
    this.controls = {type: true, zoom: true, ruler: true};
    this.zoomtool_box = this.maptype_box = this.pantools_box = this.copyright_box = this.ruler_box = null;
    this.active_events = {
        dragging: null,
        keyboard: null,
        clickzoom: null,
        mousewheel: null,
        pois: null,
        clickpoi: null
    };
    this.registered_handlers = {};
    SearchChMap.instances[this.id] = this;
    if (typeof p == 'undefined')
        p = {};
    this.set(p);
    if (this.p.internal)
        this.p.nocss = true;
    if (!this.p.nocss)
        this.loadcss();
    if (this.p.autoload && SearchChMap.pageloaded)
        this.init();
}

SearchChMap.instances = [];
SearchChMap.pageloaded = false;
SearchChMap.cssloaded = false;
SearchChMap.prototype = {
    set: function (p) {
        var run_update = false;
        var updates = {};
        for (var k in p)
            if ((typeof this.p[k] == "undefined") || (this.p[k] != p[k]))
                updates[k] = true;
        if (p.center && typeof p.center == 'object')
            this.p.center = [];
        if (p.from && typeof p.from == 'object')
            p.from = p.from.join(',');
        if (p.to && typeof p.to == 'object')
            p.to = p.to.join(',');
        it_set(this.p, p);
        if (updates.container) {
            this.mapcontainer = p.container;
            run_update = true;
        }
        if (p.zoom) {
            var zi = this.zd2zi(this.p.zoom);
            if (zi <= this.env.zoommax && zi != this.zi) {
                this.zi = zi;
                run_update = true;
            }
        }
        if (updates.from || updates.to) {
            this.p.route = (this.p.from && this.p.to) ? this.p.from + ' to ' + this.p.to : '';
            updates.route = true;
        }
        if (updates.center) {
            if (this.ready && !this.busy)
                this.geo2base(this.p.center);
            this.ready = false;
            this.remove_fade_obj();
        } else if (!updates.route && (updates.x || updates.y)) {
            this.centerx = this.fixoffset(p.x, 1);
            this.centery = this.fixoffset(p.y, -1);
            this.p.x = this.p.y = 0;
        } else if (p.center) {
            this.centerx = this.centery = 0;
        }
        if (updates.route) {
            if (!this.p.route) {
                this.p.drawing = null;
                run_update = true;
            } else if (this.ready) {
                this.loadroute(this.p.route);
                this.ready = false;
            }
        }
        if (updates.drawing)
            run_update = true;
        if (updates.poigroups) {
            this.update_poigroups(this.p.poigroups, 'set', this.ready);
        }
        if (!this.contextmenu || updates.contextmenu) {
            this.contextmenu = [];
            for (var i = 0; i < this.contextmenu_default.length; i++)
                this.contextmenu[i] = this.contextmenu_default[i];
            if (p.contextmenu) {
                this.contextmenu[this.contextmenu.length] = false;
                for (var i = 0; i < p.contextmenu.length; i++)
                    this.contextmenu[this.contextmenu.length] = p.contextmenu[i];
            }
        }
        if (updates.controls) {
            this.controls = {};
            var a_controls = this.p.controls.replace(/all/, 'type,zoom,pan,ruler').replace(/default/, 'type,zoom,ruler').split(',');
            for (var i = 0; i < a_controls.length; i++)
                this.controls[a_controls[i]] = true;
            if (this.ready && !run_update)
                this.set_gui_elements();
        }
        if (updates.type && this.p.type != this.type) {
            this.bandwidth = this.p.type == 'street' || this.p.type == 'low' ? 'low' : 'high';
            var old = this.type;
            this.type = this.p.type;
            if (this.ready && !run_update) {
                this.hide_tiles(0, false);
                this.finetune();
                this.jumpto(this.centerx, this.centery, 0, 0, 0, 0, 1, false);
                this.set_gui_elements();
                this.triggerEvent("maptypechanged", {oldtype: old, newtype: this.type});
            }
        }
        if (updates.circle) {
            if (!run_update && this.ready && this.show_circle && this.p.circle)
                this.object_jumpto(this.circle_img, this.circle_offset[0], this.circle_offset[1], this.centerx, this.centery, 1, -1, -1, -34, -34);
            else if (!run_update && this.ready)
                it_dom.moveto(this.circle_img, 0, this.maph + 1000);
        }
        if (this.ready && run_update) {
            this.hide_tiles(0, false);
            this.clear_all_tiles();
            this.update_dyn_pois();
            this.preload();
        } else if (this.ready && (p.dx || p.dy)) {
            p = this.rel2abs(p);
            this.jumpto((this.centerx = p.x), (this.centery = p.y), 0, 0, 0, 0, 1, false);
            this.clippingchanged();
        }
    },
    enable: function (s) {
        if (!this.ready) {
            this.p.enable = s;
            return;
        }
        var en = s == 'all' ? ['dragging', 'keyboard', 'clickzoom', 'mousewheel', 'pois'] : s.split(',');
        for (var evt, i = 0; i < en.length; i++) {
            evt = en[i];
            if (this.active_events[evt])
                continue;
            if ((evt == 'dragging' || evt == 'clickzoom' || evt == 'clickpoi') && !this.registered_handlers['mouseup']) {
                it_add_event({element: this.mapcontainer, event: "mousedown", object: this, method: "mousedown"});
                it_add_event({element: document, event: "mouseup", object: this, method: "mouseup"});
                this.registered_handlers['mouseup'] = true;
            } else if (evt == 'keyboard' && !this.registered_handlers[evt]) {
                it_add_event({element: document, event: "keypress", object: this, method: "keypress"});
                it_add_event({element: document, event: "keyup", object: this, method: "keyup"});
                it_add_event({element: document, event: "keydown", object: this, method: "keydown"});
                this.registered_handlers[evt] = true;
            } else if (evt == 'mousewheel' && !this.registered_handlers[evt]) {
                var listener = this.mapcontainer.addEventListener && !this.useragent.opera && !this.useragent.safari ? "DOMMouseScroll" : "mousewheel";
                it_add_event({element: this.mapcontainer, event: listener, object: this, method: "mousewheeled"});
                this.registered_handlers[evt] = true;
            } else if (evt == 'pois')
                this.radar_timer = new it_timer({
                    object: this,
                    method: 'poi_radardaemon',
                    continuous: true,
                    timeout: 50
                });
            if (evt == 'dragging')
                this.set_cursor(this.useragent.gecko ? '-moz-grab' : 'move');
            else if (evt == 'clickpoi')
                this.set_cursor('pointer');
            this.active_events[evt] = true;
        }
    },
    disable: function (s) {
        if (!this.ready) {
            this.p.disable = s;
            return;
        }
        var dis = s == 'all' ? ['dragging', 'keyboard', 'clickzoom', 'mousewheel', 'pois'] : s.split(',');
        for (var evt, i = 0; i < dis.length; i++) {
            evt = dis[i];
            this.active_events[evt] = false;
            if (evt == 'dragging')
                this.set_cursor('');
            else if (evt == 'pois' && this.radar_timer)
                this.radar_timer.stop();
        }
    },
    resize: function (w, h) {
        it_dom.resizeto(this.mapcontainer, Math.min(1200, w), Math.min(1200, h));
        this.resized();
    },
    zoom: function (i) {
        this.startzoom(0, 0, (i > 0 ? 2 : (i < 0 ? 0.5 : 0)), false);
    },
    go: function (p) {
        if (p.center && !p.method && (typeof p.center == 'object' || typeof p.center == 'string')) {
            p.method = 'go';
            this.geocoder.m2p(p.center, p);
            return;
        }
        if (p.dx || p.dy)
            p = this.rel2abs(p);
        if (p.error) {
            this.alert(p.center + ':\n' + p.error);
            this.triggerEvent("geolocationerror", {code: 0});
            return;
        }
        p.x = p.x ? p.x : 0;
        p.y = p.y ? p.y : 0;
        var dx = p.x - this.centerx;
        var dy = p.y - this.centery;
        if (Math.abs(dx) > this.mapw * 1.5 || Math.abs(dy) > this.maph * 1.5) {
            delete p.x;
            delete p.y;
            delete p.method;
            return this.set(p);
        }
        if (typeof p.circle != 'undefined') {
            this.circle_offset = [p.x, p.y];
            this.p.circle = this.show_circle = p.circle;
            if (this.show_circle && !dx && !dy)
                this.object_jumpto(this.circle_img, this.circle_offset[0], this.circle_offset[1], this.centerx, this.centery, 1, -1, -1, -34, -34);
            else if (!this.show_circle)
                it_dom.moveto(this.circle_img, 0, this.maph + 1000);
        }
        var zi;
        if (p.zoom && (zi = this.zd2zi(p.zoom)) != this.zi) {
            this.popup_hide();
            this.startzoom(dx, dy, 0, zi);
        } else if (dx || dy)
            this.moveto(p);
    },
    geolocation: function () {
        if (navigator.geolocation) {
            var self = this;
            var count = 0;
            navigator.geolocation.getCurrentPosition(function (position) {
                    var z = position.coords.accuracy > 1000 ? 32 : (position.coords.accuracy > 100 ? 2 : 1);
                    if (!count++) {
                        self.go({center: [position.coords.latitude, position.coords.longitude], zoom: z, circle: true});
                        self.triggerEvent("geolocation", {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude,
                            accuracy: position.coords.accuracy
                        });
                    }
                },
                function (error) {
                    self.triggerEvent("geolocationerror", {code: error.code});
                },
                {});
        } else
            this.alert('Operation not supported');
    },
    get: function (what) {
        var prop = {
            zoom: this.get_zd(),
            type: this.type,
            center: this.base_url.substr(1),
            drawing: this.p.drawing,
            x: Math.round(this.p2m(this.centerx)) + 'm',
            y: Math.round(this.p2m(this.centery)) + 'm',
            poigroups: this.poi,
            circle: this.show_circle && this.p.circle,
            container: this.mapcontainer,
            from: this.p.from,
            to: this.p.to,
            route: this.p.route,
            routeinfo: this.p.routeinfo
        };
        if (!what || what == 'enabled')
            prop.enabled = it_array_keys(this.active_events).join(',');
        if (!what || what == 'controls')
            prop.controls = it_array_keys(this.controls).join(',');
        return what ? prop[what] : prop;
    },
    showPOIGroup: function (p) {
        if (p != '')
            this.update_poigroups(p, 'add', true);
    },
    hidePOIGroup: function (p) {
        if (p != '')
            this.update_poigroups(p, 'remove', true);
    },
    addPOI: function (poi) {
        if (!poi || typeof poi != 'object')
            return false;
        this.dynpois[poi.id] = poi;
        if (this.ready)
            this.set_dyn_poi({id: poi.id});
        return true;
    },
    removePOI: function (poi) {
        var id = (typeof poi == 'object') ? poi.id : poi;
        if (this.dynpois[id] && this.dynpois[id].p) {
            if (this.mapcontainer)
                this.mapcontainer.removeChild(this.dynpois[id].icon);
            this.dynpois[id].ready = false;
            this.dynpois[id] = null;
            if (this.showing_dyn_poi && this.showing_dyn_poi.id == id)
                this.hide_dyn_poi();
        }
    },
    removeAllPOIs: function () {
        for (var id in this.dynpois)
            this.removePOI(id);
    },
    getPermUrl: function (mode) {
        if (mode == 'directions' && this.p.route)
            return this.service_url('/directions.html') + '?route=' + it_url_encode(this.p.route);
        var append = '';
        if (mode == 'print')
            append = 'p=1';
        else if (mode == 'email')
            append = 'e=1';
        return this.get_perm_url(append, false);
    },
    getZoom: function () {
        return this.get_zd();
    },
    init: function () {
        if (!SearchChMap.isBrowserCompatible()) {
            this.fatal("Browser is not compatible");
            return;
        }
        if (typeof this.mapcontainer == 'string')
            this.mapcontainer = document.getElementById(this.mapcontainer);
        if (!this.mapcontainer) {
            this.fatal("Map container not found");
            return;
        }
        var csspos = it_dom.computed_style(this.mapcontainer, 'position');
        if (!csspos || csspos == 'static')
            this.mapcontainer.style.position = 'relative';
        this.mapcontainer.className = (this.mapcontainer.className ? this.mapcontainer.className + ' ' : '') + 'search_mapwidget';
        if (!this.p.nocss)
            this.mapcontainer.className += ' search_reset';
        this.mapcontainer.style.overflow = 'hidden';
        this.get_map_size();
        this.calc_abs_pos();
        (this.loading_img = this.alloc_image(920)).src = this.service_url('/images/loading.gif');
        (this.circle_img = this.alloc_image(200)).src = this.service_url("/images/icons/circle." + (this.useragent.ie5 ? 'gif' : 'png'));
        this.pngfix(this.circle_img, 68, 68);
        if (this.useragent.oldgecko)
            for (var t = 0; t < this.env.tot_tiles * 2 + 3; t++)
                this.img[t] = this.alloc_image(t + 1);
        this.setmode("");
        this.ping_img = this.alloc_image(1);
        if (this.p.center)
            this.geo2base(this.p.center);
        if (this.p.route && !this.p.internal)
            this.loadroute(this.p.route);
        else if (!this.p.center && !this.p.internal)
            this.postinit();
    },
    postinit: function () {
        if (this.is_error)
            return;
        this.change_check_timer = new it_timer({object: this, method: 'change_check', continuous: true, timeout: 1000});
        it_add_event({element: this.mapcontainer, event: "mouseover", object: this, method: "mouseover"});
        it_add_event({element: this.mapcontainer, event: "mouseout", object: this, method: "mouseout"});
        it_add_event({element: document, event: "mousemove", object: this, method: "mousemoved"});
        if (this.useragent.iphone >= 2) {
            it_add_event({element: this.mapcontainer, event: "touchstart", object: this, method: "touchdown"});
            it_add_event({element: this.mapcontainer, event: "touchend", object: this, method: "touchup"});
            it_add_event({element: this.mapcontainer, event: "gesturestart", object: this, method: "gesturestart"});
            it_add_event({element: this.mapcontainer, event: "gestureend", object: this, method: "gestureend"});
            it_add_event({element: this.mapcontainer, event: "touchmove", object: this, method: "touchmoved"});
        }
        if (this.p.autoresize)
            it_event({element: window, event: 'resize', object: this, method: 'resized'});
        this.ready = true;
        this.finetune();
        this.preload();
        if (this.p.enable)
            this.enable(this.p.enable);
        if (this.p.disable)
            this.disable(this.p.disable);
        for (var pid in this.dynpois)
            this.set_dyn_poi({id: pid});
        this.geocoder.flush();
        this.addEventListener("change", "update_links", this);
        this.addEventListener("maptypechanged", "update_links", this);
    },
    update: function (ignorelayer) {
        if (this.is_error)
            return;
        this.popup_hide();
        this.jumpto(this.centerx, this.centery, 0, 0, 0, 0, 1, false, ignorelayer);
        this.set_gui_elements();
    },
    preload: function () {
        this.popup_hide();
        this.set_gui_elements();
        this.setmode("preload");
        this.jumpto(this.centerx, this.centery, 0, 0, 0, 0, 1, this.loaded);
        this.show_loading_timeout = it_now() + 2500;
        this.switch_hard = this.show_loading_timeout + 5000;
        this.switch_tiles();
        if (this.load_control_timer)
            this.load_control_timer.stop();
        this.load_control_timer = new it_timer({object: this, method: 'load_control', continuous: true, timeout: 100});
        this.s_centerx = this.centerx, this.s_centery = this.centery, this.s_check = true;
    },
    alloc_image: function (z) {
        var no = function () {
            return false;
        };
        var im = it_create_element(this.mapcontainer, 'img', {
            onmousedown: no,
            oncontextmenu: no,
            style: {position: "absolute", top: 1000 + this.maph + 'px', zIndex: z},
            unselectable: "on"
        });
        if (document.all && !document.getElementById)
            im.src = this.service_url("/images/0.gif");
        return im;
    },
    p2p: function (pixels, z_from, z_to) {
        if (typeof z_from == 'undefined') z_from = this.env.zoommax;
        if (typeof z_to == 'undefined') z_to = this.zi;
        return this.env.rect[z_from] / this.env.rect[z_to] * pixels;
    },
    p2m: function (pixels) {
        var zd = parseFloat(this.env.zoomlevels[this.zi]);
        return pixels * zd;
    },
    zd2zi: function (zd) {
        var diff, last = 0x7fffffff;
        for (var zi = 0; zi < this.env.zoomlevels.length; zi++) {
            diff = zd > this.env.zoomlevels[zi] ? zd / this.env.zoomlevels[zi] : this.env.zoomlevels[zi] / zd;
            if (diff >= last) {
                zi--;
                break;
            }
            last = diff;
        }
        return Math.min(this.env.zoommax, zi);
    },
    fixoffset: function (val, mul) {
        var zd = parseFloat(this.env.zoomlevels[this.zi]) * mul;
        if (zd && String(val).match(/^(-?[0-9\.]+)m$/))
            return parseFloat(RegExp.$1) / zd;
        return val * 1.6;
    },
    rel2abs: function (p) {
        if (p.dx && p.dx <= 1 && p.dx >= -1)
            p.dx *= this.mapw;
        if (p.dy && p.dy <= 1 && p.dy >= -1)
            p.dy *= this.maph;
        p.x = this.centerx + (p.dx ? p.dx : 0);
        p.y = this.centery + (p.dy ? p.dy : 0);
        return p;
    },
    setmode: function (newmode) {
        if ((this.mode = newmode) == "")
            ;
    },
    calc_abs_pos: function () {
        this.mapleft = it_get_obj_x(this.mapcontainer);
        this.maptop = it_get_obj_y(this.mapcontainer);
    },
    get_map_size: function () {
        var w = this.mapcontainer.clientWidth || this.mapcontainer.offsetWidth || parseInt(it_dom.computed_style(this.mapcontainer, 'width'));
        var h = this.mapcontainer.clientHeight || this.mapcontainer.offsetHeight || parseInt(it_dom.computed_style(this.mapcontainer, 'height'));
        this.mapw = Math.min(1200, Math.max(200, w));
        this.maph = Math.min(1200, Math.max(200, h));
        if (this.mapw != w || this.maph != h)
            it_dom.resizeto(this.mapcontainer, this.mapw, this.maph);
        return [this.mapw, this.maph];
    },
    set_map_size: function (w, h) {
        this.mapw = w;
        this.maph = h;
        it_dom.resizeto(this.mapcontainer, w, h);
    },
    resized: function () {
        var w = this.mapw;
        var h = this.maph;
        this.get_map_size();
        if (this.ready && (this.mapw != w || this.maph != h)) {
            this.finetune();
            this.jumpto(this.centerx, this.centery, 0, 0, 0, 0, 1, false);
            this.clippingchanged();
        }
    },
    clippingchanged: function () {
        var new_clipping = this.get_boundingbox();
        if (new_clipping.base != this.currentclipping.base ||
            new_clipping.route != this.currentclipping.route ||
            new_clipping.zd != this.currentclipping.zd ||
            new_clipping.x1 != this.currentclipping.x1 || new_clipping.x2 != this.currentclipping.x2 ||
            new_clipping.y1 != this.currentclipping.y1 || new_clipping.y2 != this.currentclipping.y2) {
            this.currentclipping = new_clipping;
            this.triggerEvent("change", this.currentclipping);
        }
    },
    service_url: function (s, addkey) {
        return this.env.map_server + s + (addkey && this.env.apikey ? "&key=" + this.env.apikey : "");
    },
    get_perm_url: function (append, rel) {
        var q = "";
        var z = this.get_z();
        var poi = this.poi_compact(this.poi_active());
        var base = this.p.route ? '/' : this.base_url;
        q += this.p.route ? "&route=" + it_url_encode(this.p.route) : "";
        q += this.centerx ? "&x=" + Math.round(this.p2m(this.centerx) + (this.p.route_offset ? this.p.route_offset[0] : 0)) + 'm' : "";
        q += this.centery ? "&y=" + Math.round(this.p2m(-this.centery) + (this.p.route_offset ? this.p.route_offset[1] : 0)) + 'm' : "";
        q += this.env.publictelparams ? ("&" + this.env.publictelparams) : "";
        q += (z != this.default_z) ? "&z=" + z : ""
        q += this.poi_sticky ? "&poi=" + poi : "";
        q += this.bandwidth != this.default_bandwidth ? "&b=" + this.bandwidth : "";
        q += append ? "&" + append : "";
        if (base.indexOf('?') < 0)
            q = q.replace(/&/, '?');
        return (rel ? base : this.service_url(base)) + q;
    },
    change_check: function () {
        if (it_now() - this.lastping > 9999 && it_now() - this.lastactivity < 10000) {
            this.lastping = it_now();
            if (this.ping_img && !this.env.noads)
                this.ping_img.src = this.service_url('/images/ping.gif?x=' + this.lastactivity + '/' + "" + '/' + this.get_perm_url('', true));
        }
    },
    get_boundingbox: function (stretched) {
        var stretch = stretched ? this.env.zoomlevels[this.zi] / this.env.zoomlevels[this.env.zoommax] : 1;
        return {
            base: this.base,
            route: this.p.route,
            x1: this.topx * stretch,
            y1: this.topy * stretch,
            x2: (this.topx + this.mapw) * stretch,
            y2: (this.topy + this.maph) * stretch,
            zd: this.get_zd(),
            z: this.get_z()
        };
    },
    get_z: function () {
        return this.env.zoomparams[this.zi];
    },
    get_zd: function () {
        return this.env.zoomlevels[this.zi];
    },
    geo2base: function (geodata) {
        var request = {zd: this.get_zd()};
        if (typeof geodata == 'object')
            request.coords = geodata.join(',');
        else
            request.address = geodata;
        if (this.base)
            request.oldbase = this.base;
        this.busy = true;
        this.loader.clear();
        this.loader.post(this.service_url("/api/?action=getbase&charset=" + this.charset, true), request);
    },
    loadroute: function (route) {
        if (!this.routeloader)
            this.routeloader = new it_loader(this);
        var request = {route: route, zd: this.get_zd()};
        if (this.base)
            request.base = this.base;
        this.busy = true;
        this.routeloader.clear();
        this.routeloader.post(this.service_url("/api/?action=route&charset=" + this.charset, true), request);
    },
    set_base: function (p) {
        this.base = p.base;
        this.base_url = p.base_url;
        this.coord_base = p.coord_base;
        this.default_z = p.z;
        this.show_circle = p.circle;
        this.transform = p.transform;
        this.circle_offset = (p.circle && p.circle_offset) ? p.circle_offset : [0, 0];
        if (p.drawing)
            this.p.drawing = p.drawing;
        if (p.base_corr)
            this.base_corr = p.base_corr;
        if (!this.p.zoom)
            this.zi = p.zi;
        this.centerx = this.p.x ? this.fixoffset(this.p.x, 1) : (p.x ? this.fixoffset(p.x, 1) : 0);
        this.centery = this.p.y ? this.fixoffset(this.p.y, -1) : (p.y ? this.fixoffset(p.y, -1) : 0);
        if (this.p.x || this.p.y)
            this.p.x = this.p.y = 0;
        if (p.message)
            this.display_message(p.message);
        if (p.dx || p.dy) {
            p.dx = this.p2p(p.dx, p.zi, this.env.zoommax);
            p.dy = this.p2p(p.dy, p.zi, this.env.zoommax)
            for (var i in this.dynpois)
                if (this.dynpois[i] && this.dynpois[i].p) {
                    this.dynpois[i].px += p.dx;
                    this.dynpois[i].py += p.dy;
                }
        }
        if (!this.loaded)
            this.postinit();
        else if (!this.ready) {
            this.ready = true;
            this.hide_tiles(0, false);
            this.clear_all_tiles();
            this.update_dyn_pois();
            this.finetune();
            this.preload();
        }
    },
    render: function (loader) {
        if (loader.attr.pois) {
            this.poi_packed[loader.baseurl] = loader.attr.pois;
            this.poi_findpopup();
        } else if (loader.attr.request && loader.attr.request == 'getbase') {
            this.busy = false;
            this.set_base(loader.attr);
        } else if (loader.attr.request && loader.attr.request == 'route') {
            this.busy = false;
            this.p.route = loader.attr.route;
            this.p.drawing = loader.attr.drawing;
            this.p.routeinfo = {distance: loader.attr.distance, time: loader.attr.time, text: loader.attr.description};
            if (loader.attr.from) this.p.from = loader.attr.from.text;
            if (loader.attr.to) this.p.to = loader.attr.to.text;
            var oldzoom = this.zi;
            if (!this.p.zoom && loader.attr.from && loader.attr.to) {
                var width = Math.abs(loader.attr.from.x - loader.attr.to.x);
                var height = Math.abs(loader.attr.from.y - loader.attr.to.y);
                for (var zd, zi = this.env.zoommax; zi >= 0; zi--) {
                    if (this.p2p(width, this.env.zoommax, zi) <= this.mapw && this.p2p(height, this.env.zoommax, zi) <= this.maph) {
                        this.p.zoom = this.env.zoomlevels[zi];
                        this.zi = loader.attr.zi = zi;
                        break;
                    }
                }
            }
            if (!this.p.center)
                this.set_base(loader.attr);
            else {
                this.preload_count = 0;
                this.jumpto(this.centerx, this.centery, 0, 0, 0, 0, 1, false, (oldzoom == this.zi ? 'bg' : ''));
                this.clippingchanged();
            }
            this.ready = true;
        } else if (loader.attr.redirect)
            location.href = loader.attr.redirect;
        if (loader.attr.verbose)
            ED(loader.attr.verbose);
    },
    mouseover: function (e) {
        this.map_mouseinside = true;
        this.triggerEvent("mouseover");
    },
    mouseout: function (e) {
        this.map_mouseinside = false;
        this.triggerEvent("mouseout");
    },
    mousemoved: function (e) {
        var coords = search_mouse_pos(e);
        var src = search_get_target(e);
        this.screenx = coords[0];
        this.screeny = coords[1];
        if (src.offsetParent == this.mapcontainer) {
            var rel = search_rel_mouse_pos(e);
            this.mapleft = this.screenx - rel[0] - src.offsetLeft;
            this.maptop = this.screeny - rel[1] - src.offsetTop;
        }
        this.mousex = this.screenx - this.mapleft;
        this.mousey = this.screeny - this.maptop;
        this.poi_mouset = it_now();
        if (this.map_mouseinside) {
            this.triggerEvent("mousemove", this.map_event());
        }
        return !(this.map_mouseinside || this.mode == 'drag');
    },
    mousedown: function (e) {
        var ev = search_get_event(e);
        var button = ((ev.button && ev.button == 2) || (ev.which && ev.which == 2) || ev.shiftKey || ev.ctrlKey) ? 2 : 1;
        if (button == 2) {
            this.contextmenu_timer = new it_timer({
                object: this,
                method: 'contextmenu_show',
                timeout: (!this.active_events.clickzoom || this.contextmenu_shown() ? 0 : 250),
                x: this.mousex,
                y: this.mousey
            });
        } else if (this.contextmenu_shown()) {
            this.contextmenu_hide();
            return false;
        }
        if (this.popup_mouseinside(true) || this.contextmenu_shown() || !this.map_mouseinside)
            return true;
        if (this.mode == "" && (this.active_events.dragging || this.active_events.clickzoom)) {
            this.setmode("drag");
            this.drag_start_time = it_now();
            this.drag_started = false;
            this.drag_distance = 0;
            var coords = search_mouse_pos(e);
            this.prevx = coords[0], this.prevy = coords[1];
            if (this.useragent.gecko && this.active_events.dragging)
                this.set_cursor('-moz-grabbing');
            this.dragpoll_timer = new it_timer({object: this, method: 'dragpoll', continuous: true, timeout: 20});
        }
        this.mousemoved(e);
        return (this.active_events.dragging || this.active_events.clickzoom) ? it_event_void(e) : true;
    },
    deselectall: function () {
        var selection;
        if (window.getSelection && (selection = window.getSelection()))
            selection.removeAllRanges();
    },
    dragpoll: function () {
        var dx = this.screenx - this.prevx;
        var dy = this.screeny - this.prevy;
        this.prevx = this.screenx;
        this.prevy = this.screeny;
        this.drag_distance += dx * dx + dy * dy;
        if (this.mode == "drag" && this.active_events.dragging && (dx || dy)) {
            if (!this.drag_started) {
                this.drag_started = true;
                this.triggerEvent("dragstart");
            }
            this.jumpto(this.centerx -= dx, this.centery -= dy, dy > 0, dx < 0, dy < 0, dx > 0, 1, false);
        }
    },
    mouseup: function (e) {
        if (this.contextmenu_timer) {
            this.contextmenu_timer.stop();
            this.contextmenu_timer = null;
        }
        if (this.contextmenu_mouseinside() || (this.contextmenu_shown() > 1))
            return this.contextmenu_click(e);
        if ((this.popup_mouseinside(true) && this.mode != "drag") || this.mode == "preload")
            return true;
        var clickpoi = this.active_events.clickpoi;
        var ev = search_get_event(e);
        var map_event = this.map_event();
        map_event.button = ((ev.button && ev.button == 2) || (ev.which && ev.which == 2) || ev.shiftKey || ev.ctrlKey) ? 2 : 1;
        if (this.mode == "drag") {
            if (this.useragent.gecko && this.active_events.dragging)
                this.set_cursor('-moz-grab');
            if (this.dragpoll_timer) {
                this.dragpoll_timer.stop();
                this.dragpoll_timer = null;
            }
            if (this.drag_started)
                this.triggerEvent("dragend");
            this.setmode("");
            this.drag_started = false;
            if (this.drag_distance < this.drag_limit && it_now() < (this.drag_start_time + this.drag_timeout)) {
                if (this.triggerEvent("mouseclick", map_event) && this.active_events.clickzoom && !this.linkclicked(ev)) {
                    if (map_event.button == 2)
                        this.startzoom(0, 0, 0.5, false);
                    else
                        this.startzoom(map_event.x, map_event.y, 2, false);
                }
            }
            if (this.drag_distance >= this.drag_limit)
                clickpoi = false;
            ;
        }
        if (clickpoi && this.map_mouseinside) {
            this.poi_mousex = this.mousex + this.topx;
            this.poi_mousey = this.mousey + this.topy;
            if (this.triggerEvent("mouseclick", map_event))
                this.poi_trigger();
        }
        if (this.active_events.dragging || this.mode != "")
            this.endpan();
        return true;
    },
    touchevent: function (e) {
        return {
            pageX: e.pageX,
            pageY: e.pageY,
            offsetX: e.pageX - e.target.offsetLeft,
            offsetY: e.pageY - e.target.offsetTop,
            target: e.target
        };
    },
    touchdown: function (e) {
        if (e.touches.length == 1) {
            this.map_mouseinside = true;
            if (!this.mousedown(this.touchevent(e.touches[0])))
                e.preventDefault();
        }
    },
    touchup: function (e) {
        var now = it_now();
        if (this.touch_time && this.mode == 'drag' && !this.popup_mouseinside(true) && (now - this.touch_time) < 600) {
            this.setmode("");
            this.startzoom(this.mousex - this.mapw / 2, this.mousey - this.maph / 2, 2, false);
            e.preventDefault();
        } else if (e.changedTouches.length) {
            this.mouseup(this.touchevent(e.changedTouches[0]));
        }
        this.touch_time = this.touch_time ? 0 : now;
    },
    touchmoved: function (e) {
        if (e.changedTouches.length) {
            if (!this.mousemoved(this.touchevent(e.changedTouches[0])))
                e.preventDefault();
        }
    },
    gesturestart: function () {
        this.setmode("");
    },
    gestureend: function (e) {
        if (e.scale > 0 && (e.scale < 1 || e.scale > 1))
            this.zoom(e.scale - 1);
        this.touch_time = 0;
    },
    triggerEvent: function (evt, e) {
        var transform = e && this.transform && this.transform[this.zi];
        if (transform && (typeof e.x != "undefined")) {
            e.mx = Math.round((e.x + this.centerx) * transform[0] + transform[1]);
            e.my = Math.round((e.y + this.centery) * transform[2] + transform[3]);
        }
        if (transform && (typeof e.x1 != "undefined")) {
            e.mx1 = Math.round((e.x1) * transform[0] + transform[1]);
            e.my1 = Math.round((e.y1) * transform[2] + transform[3]);
            e.mx2 = Math.round((e.x2) * transform[0] + transform[1]);
            e.my2 = Math.round((e.y2) * transform[2] + transform[3]);
        }
        return this._triggerEvent(evt, e);
    },
    linkclicked: function (ev) {
        var elm = ev.target || ev.srcElement;
        return elm &&
            ((elm.nodeName && elm.nodeName == "A") ||
                (elm.parentNode && elm.parentNode.nodeName && elm.parentNode.nodeName == "A"));
    },
    mousewheeled: function (e) {
        if (this.popup_mouseinside())
            return true;
        var ev = search_get_event(e);
        var vx = 0;
        var vy = ev.wheelDelta ? ev.wheelDelta / 120 * 30 : (ev.detail ? -ev.detail * 30 : 0);
        if (this.useragent.opera)
            vy = -vy;
        if (ev.shiftKey || ev.ctrlKey) {
            vx = vy;
            vy = 0;
        }
        this.jumpto(this.centerx -= vx, this.centery -= vy, vy > 0, vx < 0, vy < 0, vx > 0, 1, false);
        return false;
    },
    pan_mousedown: function (e) {
        var obj = search_get_target(e);
        var rel = search_rel_mouse_pos(e);
        if (!this.useragent.ie) {
            var pos = search_mouse_pos(e);
            var ref = it_rel_obj_pos(obj, this.mapcontainer);
            var offx = this.useragent.gecko ? parseInt(this.mapcontainer.style.getPropertyValue('border-left-width')) : 1;
            var offy = this.useragent.gecko ? parseInt(this.mapcontainer.style.getPropertyValue('border-top-width')) : 1;
            rel[0] = pos[0] - this.mapleft - ref[0] - (isNaN(offx) ? 1 : offx);
            rel[1] = pos[1] - this.maptop - ref[1] - (isNaN(offy) ? 1 : offy);
        }
        rel[0] -= Math.floor(obj.offsetWidth / 2);
        rel[1] -= Math.floor(obj.offsetHeight / 2);
        this.startpan(rel[0] > 6 ? 1 : (rel[0] < -6 ? -1 : 0), rel[1] > 6 ? 1 : (rel[1] < -6 ? -1 : 0));
    },
    pan_mouseup: function (e) {
        this.endpan();
    },
    startpan: function (dx, dy) {
        this.starttime = it_now();
        this.startx = this.centerx;
        this.starty = this.centery;
        this.vx = this.panspeed * dx;
        this.vy = this.panspeed * dy;
        if (this.mode == "" && (dx || dy)) {
            this.setmode("pan");
            this.triggerEvent("panstart");
            if (!this.pan_timer)
                this.pan_timer = new it_timer({
                    object: this,
                    method: 'dopan',
                    continuous: true,
                    timeout: 20 * this.x11factor
                });
        }
        return false;
    },
    dopan: function () {
        var t = it_now() - this.starttime;
        this.jumpto(this.centerx = this.startx + this.vx * t, this.centery = this.starty + this.vy * t, this.vy < 0, this.vx > 0, this.vy > 0, this.vx < 0, 1, false);
    },
    endpan: function () {
        if (this.pan_timer) {
            this.pan_timer.stop();
            this.pan_timer = null;
        }
        if (this.mode == "pan") {
            this.setmode("");
            this.triggerEvent("panend");
            this.clippingchanged();
        } else if (this.mode.indexOf("zoom") != 0)
            this.clippingchanged();
        return false;
    },
    moveto: function (p) {
        this.starttime = it_now();
        this.startx = this.centerx;
        this.starty = this.centery;
        p.dx = p.x - this.startx;
        p.dy = p.y - this.starty;
        p.duration = p.duration ? p.duration : ((Math.abs(p.dx) > this.mapw) || (Math.abs(p.dy) > this.maph) ? 3000 : 1000);
        this.move_params = p;
        if (this.mode == "") {
            this.setmode("move");
            this.move_timer = new it_timer({
                object: this,
                method: 'move',
                continuous: true,
                timeout: 20 * this.x11factor
            });
        }
    },
    move: function () {
        var percent, perc;
        var t = it_now() - this.starttime;
        var p = this.move_params;
        percent = perc = Math.min(1, t / p.duration);
        perc = Math.sin(perc * 1.57);
        var dx = p.dx * perc, dy = p.dy * perc;
        if (((Math.abs(dx) < this.mapw) && (Math.abs(dy) < this.maph)) || ((Math.abs(p.dx - dx) < this.mapw) && (Math.abs(p.dy - dy) < this.maph)))
            this.jumpto(this.centerx = this.startx + Math.round(p.dx * perc), this.centery = this.starty + Math.round(p.dy * perc), 0, 0, 0, 0, 1, false);
        else
            this.clear_all_tiles();
        if (percent >= 1)
            this.endmove();
    },
    endmove: function () {
        this.move_timer.stop();
        this.move_timer = 0;
        if (this.mode == "move")
            this.setmode("");
        if (this.move_params.zoomto_zi && (this.move_params.zoomto_zi > this.zi))
            this.startzoom(0, 0, 0, this.move_params.zoomto_zi);
        this.clippingchanged();
    },
    keydown: function (e) {
        var ev = search_get_event(e);
        var key = ev.keyCode;
        if (!this.active_events.keyboard || this.ignore_event(ev) || this.irrelevant_key(ev))
            return true;
        if (!this.pressed[key]) {
            this.pressed[key] = 1;
            if (key >= 37 && key <= 40 && this.mode.indexOf("zoom") != 0)
                this.startpan((this.pressed[37] ? -1 : 0) + (this.pressed[39] ? 1 : 0), (this.pressed[38] ? -1 : 0) + (this.pressed[40] ? 1 : 0));
            else if (key == 107 && this.mode == "")
                this.startzoom(0, 0, 2, false);
            else if (key == 109 && this.mode == "")
                this.startzoom(0, 0, 0.5, false);
        }
        return it_event_void(e);
    },
    keypress: function (e) {
        var ev = search_get_event(e);
        return (this.ignore_event(ev) || this.irrelevant_key(ev)) ? true : it_event_void(e);
    },
    keyup: function (e) {
        var ev = search_get_event(e);
        var key = ev.keyCode;
        var nomore = true;
        if (!this.active_events.keyboard)
            return false;
        else if (this.ignore_event(ev) || this.irrelevant_key(ev))
            return true;
        this.pressed[key] = 0;
        for (var i = 0; i < this.pressed.length; i++)
            if (this.pressed[i])
                nomore = false;
        if (nomore)
            this.endpan();
        else if (key >= 37 && key <= 40 && this.mode == "pan")
            this.startpan((this.pressed[37] ? -1 : 0) + (this.pressed[39] ? 1 : 0), (this.pressed[38] ? -1 : 0) + (this.pressed[40] ? 1 : 0));
        return false;
    },
    irrelevant_key: function (ev) {
        var key = ev.keyCode;
        return ev.altKey || key < 37 || (key > 40 && key != 107 && key != 109);
    },
    ignore_event: function (ev) {
        var t = search_get_target(ev);
        return ((t.tagName == "INPUT" && t.type == "text") || (t.tagName == "SELECT") || (t.tagName == "TEXTAREA") || ev.metaKey || ev.ctrlKey)
    },
    contextmenu_show: function (p) {
        this.deselectall();
        this.contextmenu_hide();
        this.setmode('');
        this.set_cursor('');
        var div = this.contextmenudiv;
        if (!div) {
            div = this.contextmenudiv = document.createElement('div');
            div.className = "search_reset search_mapwidget_contextmenu";
            it_event({element: div, event: 'mousedown', object: this, method: 'contextmenu_ignore'});
            it_event({element: div, event: 'contextmenu', object: this, method: 'contextmenu_ignore'});
            it_event({element: div, event: 'mouseup', object: this, method: 'contextmenu_click'});
            it_event({element: div, event: 'click', object: this, method: 'contextmenu_click'});
            document.body.appendChild(div);
        }
        if (!div.shown) {
            this.contextmenu_event = p;
            var x = p.x + this.mapleft + 2;
            var y = p.y + this.maptop - 10;
            var html = [], h = 0;
            for (var i = 0; i < this.contextmenu.length; i++) {
                var item = this.contextmenu[i];
                if (item) {
                    var classname = !item.method || this.contextmenu_call(item, "disabled") ? "disabled" : "enabled";
                    html[h++] = "<a class='" + classname + "' href='#'>" + item.label + "</a>";// Hover css only works on A tag in IE6
                } else if (typeof item != 'undefined')
                    html[h++] = "<div class='hr'></div>";// Using tag HR was causing layout problems with IE6
            }
            try {
                div.innerHTML = "<table><tr><td>" + html.join("") + "</td></tr></table>";
            } catch (e) {
            }
            it_set(div, {
                style: {
                    left: 0,
                    top: 0,
                    zIndex: -65536,
                    visibility: "hidden",
                    display: "block"
                }
            }) + "]";
            var h = div.offsetHeight;
            var w = div.offsetWidth;
            var size = search_client_size();
            var scroll = search_scroll_offset();
            if (x + w > size[0] + scroll[0] - 10)
                x = Math.max(scroll[0], x - w - 4);
            if (y + h > size[1] + scroll[1] - 10)
                y = Math.max(scroll[1], y - h - 4);
            it_set(div, {
                shown: 1, style: {
                    left: x + "px",
                    top: y + "px",
                    zIndex: 65535,
                    visibility: "visible"
                }
            }) + "]";
        } else
            this.contextmenu_hide();
    },
    contextmenu_hide: function () {
        if (this.contextmenudiv)
            it_set(this.contextmenudiv, {shown: 0, style: {display: "none"}});
    },
    contextmenu_ignore: function (ev) {
        return it_event_void(ev);
    },
    contextmenu_click: function (ev) {
        var div = search_get_target(ev);
        if (this.contextmenu_shown()) {
            this.contextmenu_hide();
            if (div.className != "disabled") {
                for (var i = 0; i < this.contextmenu.length; i++) {
                    var item = this.contextmenu[i];
                    if (item && item.label == div.innerHTML) {
                        this.contextmenu_call(item);
                        break;
                    }
                }
            }
        }
        return it_event_void(ev);
    },
    contextmenu_call: function (item, method) {
        var result = false;
        method = method || "method";
        try {
            var obj = item.object || window;
            var func = item[method];
            this.mousex = this.contextmenu_event.x;
            this.mousey = this.contextmenu_event.y;
            if (typeof func == "string")
                result = obj[func](item.param, this.map_event());
            else if (func)
                result = func(item.param, this.map_event());
        } catch (e) {
            this.alert(e);
        }
        return result;
    },
    contextmenu_shown: function () {
        return this.contextmenudiv && this.contextmenudiv.shown && this.contextmenudiv.shown++;
    },
    contextmenu_mouseinside: function () {
        var result = false;
        if (this.contextmenudiv && this.contextmenudiv.shown) {
            var pl = this.contextmenudiv.offsetLeft;
            var pr = pl + this.contextmenudiv.offsetWidth;
            var pt = this.contextmenudiv.offsetTop;
            var pb = pt + this.contextmenudiv.offsetHeight;
            result = (this.mousex >= pl && this.mousex <= pr && this.mousey >= pt && this.mousey <= pb);
        }
        return result;
    },
    contextmenu_zoomdisabled: function () {
        return this.zi == 0;
    },
    map_event: function () {
        var result = {
            x: Math.round(this.mousex - this.mapw / 2),
            y: Math.round(this.mousey - this.maph / 2)
        };
        var transform = this.transform && this.transform[this.zi];
        if (transform) {
            result.mx = Math.round((this.mousex - this.mapw / 2 + this.centerx) * transform[0] + transform[1]);
            result.my = Math.round((this.mousex - this.mapw / 2 + this.centery) * transform[2] + transform[3]);
        }
        return result;
    },
    settile: function (t, hx, hy, zhx, zhy, preloadMode, fgLayer) {
        t += preloadMode ? this.env.tot_tiles - this.dbl_offset : this.dbl_offset;
        var tile = this.img[t];
        if (this.boxleft - zhx < this.ztilew && this.boxright > zhx && this.boxtop - zhy < this.ztileh && this.boxbottom > zhy) {
            var mapref = this;
            if (!tile)
                tile = this.img[t] = this.alloc_image(t + 1);
            var tileSrc = this.get_tile_src(hx, hy, this.tilew, this.tileh, fgLayer);
            tile.width = Math.ceil(this.ztilew);
            tile.height = Math.ceil(this.ztileh);
            if (tile.src.indexOf(tileSrc) >= 0) {
                if (!tile.isloading || (this.useragent.opera && this.useragent.opera < 8)) {
                    it_dom.moveto(tile, (zhx - this.topx), (zhy - this.topy));
                    it_dom.set_z(tile, t + 1);
                }
            } else if (this.mode != "zoom") {
                this.preload_count++;
                it_dom.moveto(tile, 0, 1000 + this.maph);
                tile.onload = function () {
                    mapref.tile_load_end(this, (zhx - mapref.topx), (zhy - mapref.topy), t + 1);
                };
                tile.onerror = function () {
                    mapref.tile_load_error(this);
                };
                tile.isloading = true;
                tile.src = tileSrc;
            }
        } else if (tile)
            it_dom.moveto(tile, 0, 1000 + this.maph);
    },
    get_tile_src: function (hx, hy, w, h, fgLayer) {
        var server = this.env.tile_server + (fgLayer == 1 && this.useragent.ie5 ? '.gif' : this.env.layer_format[this.bandwidth][fgLayer == 1 ? 1 : 0]);
        var hashed = this.coord_base + (this.p.route ? '&route=' + it_url_encode(this.p.route) : '') + "&layer=" + (fgLayer >= 1 && this.p.route ? 'route,' : '') + this.env.layer_src[this.bandwidth][fgLayer] + (fgLayer >= 1 && this.p.drawing ? ",draw&d=" + this.p.drawing + "&timestamp=" + this.startuptimestamp : "") + "&zd=" + this.env.zoomlevels[this.zi] + '&n=' + this.env.n + (this.env.tile_src_add ? this.env.tile_src_add : '');
        return server + "?x=" + this.p2m(Math.round(hx + w / 2)) + "m&y=" + this.p2m(Math.round(-hy - h / 2)) + "m&w=" + w + "&h=" + h + (fgLayer >= 1 ? "&poi=" + this.poi_compact(this.poi_active()) : "") + hashed;
    },
    tile_load_end: function (me, x, y, z) {
        it_dom.moveto(me, x, y);
        it_dom.set_z(me, z);
        me.isloading = false;
        me.onload = null;
        me.onerror = null;
        if (me.src.indexOf("/images/0.gif") == -1) {
            if (this.preload_count > 0 && --this.preload_count == 0 && !this.loaded) {
                this.readytime = it_now();
                this.triggerEvent("load", {x: 0, y: 0});
                this.sendaudit();
                this.loaded = true;
            }
        }
        this.pngfix(me, this.tilew, this.tileh);
    },
    tile_load_error: function (me) {
        me.isloading = false;
        me.onerror = null;
        me.onload = null;
        if (this.preload_count > 0)
            this.preload_count--;
    },
    switch_tiles: function () {
        if (this.loaded) {
            this.dbl_offset = this.env.tot_tiles - this.dbl_offset;
            this.jumpto(this.centerx, this.centery, 0, 0, 0, 0, 1, false);
            this.hide_tiles(2, true);
        }
    },
    hide_tiles: function (mode, use_z, layer) {
        var o = mode == 0 ? 0 : (mode == 1 ? this.dbl_offset : this.env.tot_tiles - this.dbl_offset);
        var start = (layer == 'fg' ? this.env.tot_tiles / 2 : 0);
        for (var i = start; i < this.env.tot_tiles * ((mode == 0) ? 2 : 1); i++) {
            if (this.img[i + o]) {
                if (use_z)
                    it_dom.set_z(this.img[i + o], 0);
                else
                    it_dom.set_style(this.img[i + o], 'top', (1000 + this.maph) + 'px');
            }
        }
        if (this.circle_img && mode == 0)
            it_dom.moveto(this.circle_img, 0, this.maph + 1000);
    },
    clear_tiles: function () {
        var o = this.env.tot_tiles - this.dbl_offset;
        for (var i = 0; i < this.env.tot_tiles; i++)
            if (this.img[i + o])
                this.img[i + o].src = this.service_url("/images/0.gif");
    },
    clear_all_tiles: function () {
        for (var i = 0; i < this.env.tot_tiles * 2; i++)
            if (this.img[i])
                this.img[i].src = this.service_url("/images/0.gif");
    },
    reload_tiles: function (layer, bbox) {
        for (var img, i = this.dbl_offset; i < this.env.tot_tiles * 2; i++) {
            if ((img = this.img[i]) && img.src.match('layer=' + layer)) {
                if (bbox && img.src.match(/x=([\-\d]+)&y=([\-\d]+)&w=([\-\d]+)&h=([\-\d]+)/) &&
                    (parseInt(RegExp.$1) > bbox[2] || parseInt(RegExp.$1) + parseInt(RegExp.$3) < bbox[0] ||
                        parseInt(RegExp.$2) > bbox[3] || parseInt(RegExp.$2) + parseInt(RegExp.$4) < bbox[1]))
                    continue;
                img.src = img.src.replace(/(&timestamp=\d+)?$/, '&timestamp=' + it_now());
            }
        }
    },
    set_cursor: function (val) {
        it_dom.set_style(this.mapcontainer, 'cursor', val);
        for (var i = 0; i < this.mapcontainer.childNodes.length; i++) {
            if (this.mapcontainer.childNodes[i].tagName && (this.mapcontainer.childNodes[i].tagName == "IMG"))
                it_dom.set_style(this.mapcontainer.childNodes[i], 'cursor', val);
        }
    },
    finetune: function () {
        var bg = this.env.layer_src[this.bandwidth][0];
        if (!this.zl_adj[bg])
            this.zl_adj[bg] = [];
        if (!this.zl_adj[bg][this.zi]) {
            if (this.mapw < this.env.maxtilesize - 16 && this.maph < this.env.maxtilesize - 16) {
                this.tilew = this.mapw + 16;
                this.tileh = this.maph + 16;
            } else {
                this.tilew = this.mapw * 0.52 + 16;
                this.tileh = this.maph * 0.52 + 16;
            }
            this.tilew = Math.max(this.tilew, 256);
            this.tileh = Math.max(this.tileh, 256);
            this.tilew = Math.floor((this.tilew + 15) / 16) * 16;
            this.tileh = Math.floor((this.tileh + 15) / 16) * 16;
            var deltax = (this.centerx - this.mapw / 2) % this.tilew - (this.tilew - this.mapw % this.tilew) % this.tilew / 2;
            var deltay = (this.centery - this.maph / 2) % this.tileh - (this.tileh - this.maph % this.tileh) % this.tileh / 2;
            deltax -= (deltax + 1600000) % 16 - this.base_corr[bg].x[this.zi];
            deltay -= (deltay + 1600000) % 16 - this.base_corr[bg].y[this.zi];
            this.zl_adj[bg][this.zi] = new Array(deltax, deltay, this.tilew, this.tileh);
        } else {
            this.tilew = this.zl_adj[bg][this.zi][2];
            this.tileh = this.zl_adj[bg][this.zi][3];
        }
    },
    jumpto: function (curx, cury, gu, gr, gd, gl, scale, preloadMode, ignorelayer) {
        this.lastactivity = it_now();
        var bg = this.env.layer_src[this.bandwidth][0];
        var finex = this.zl_adj[bg][this.zi] ? this.zl_adj[bg][this.zi][0] : 0;
        var finey = this.zl_adj[bg][this.zi] ? this.zl_adj[bg][this.zi][1] : 0;
        this.topx = Math.floor(curx - this.mapw / 2);
        this.topy = Math.floor(cury - this.maph / 2);
        var homex = this.topx - (this.topx + 1000 * this.tilew) % this.tilew + finex;
        var homey = this.topy - (this.topy + 1000 * this.tileh) % this.tileh + finey;
        while (homex > this.topx)
            homex -= this.tilew;
        while (homey > this.topy)
            homey -= this.tileh;
        var zhomex = curx + (homex - curx) * scale;
        var zhomey = cury + (homey - cury) * scale;
        this.ztilew = this.tilew * scale;
        this.ztileh = this.tileh * scale;
        this.boxleft = this.topx - gl * this.tilew;
        this.boxright = this.topx + this.mapw + gr * this.tilew;
        this.boxtop = this.topy - gu * this.tilew;
        this.boxbottom = this.topy + this.maph + gd * this.tileh;
        if (this.show_circle && this.p.circle && preloadMode == false)
            this.object_jumpto(this.circle_img, this.circle_offset[0], this.circle_offset[1], curx, cury, scale, -1, -1, -34, -34);
        if (this.popup_poi && this.popup && preloadMode == false) {
            var offx = offy = 0;
            if (this.popup.scrollWidth) {
                var poi_y = (this.popup_poi.y - cury) * scale + 12;
                offx = this.popup.offsetWidth + (this.popup_poi.x - curx) * scale + this.mapw / 2 + 1 + this.popup_bar - this.mapw;
                offy = Math.max((this.popup.offsetHeight + poi_y + this.maph / 2 + 1 - this.maph), ((this.popup.offsetHeight + poi_y > this.maph / 2) ? this.popup.offsetHeight + 24 : 0));
            }
            this.object_jumpto(this.popup, this.popup_poi.x, this.popup_poi.y + 12, curx + (offx > 0 ? offx : 0), cury + (offy > 0 ? offy : 0), scale, this.mapw, this.maph, 0, 0);
        }
        this.hslayer = !this.p.nofg && (this.poi || (this.env.layer_src[this.bandwidth][1] && (scale == 1 || location.host.match('zoomgif')))) && !location.host.match('nofg');
        for (var j = 0; j < 2; j++) {
            for (var yi = 0; yi < this.env.num_tiles; yi++) {
                for (var xi = 0; xi < this.env.num_tiles; xi++) {
                    var zhx = zhomex + xi * this.ztilew;
                    if (Math.floor(zhx) != zhx && !this.useragent.ie5) zhx = Math.floor(zhx);
                    var zhy = zhomey + yi * this.ztileh;
                    if (Math.floor(zhy) != zhy && !this.useragent.ie5) zhy = Math.floor(zhy);
                    var t = (Math.floor(homex / this.tilew) + xi + 1000 * this.env.num_tiles) % this.env.num_tiles
                        + ((Math.floor(homey / this.tileh) + yi + 1000 * this.env.num_tiles) % this.env.num_tiles) * this.env.num_tiles;
                    if (!j && !location.host.match('nobg') && ignorelayer != 'bg')
                        this.settile(t, homex + xi * this.tilew, homey + yi * this.tileh, zhx, zhy, preloadMode, 0);
                    if (j && this.hslayer && this.mode != "zoom")
                        this.settile(t + this.env.tot_tiles / 2, homex + xi * this.tilew, homey + yi * this.tileh, zhx, zhy, preloadMode, 1);
                }
            }
        }
        if ((this.s_centerx != this.centerx || this.s_centery != this.centery) && this.s_check) {
            this.hide_tiles(2, false);
            this.s_check = false;
        }
        var dyn;
        for (var id in this.dynpois) {
            if ((dyn = this.dynpois[id]) && dyn.ready && dyn.icon)
                this.object_jumpto(dyn.icon, (dyn.x = this.p2p(dyn.px)), (dyn.y = this.p2p(dyn.py)),
                    curx, cury, scale, -1, -1, -dyn.offsetx, -dyn.offsety);
        }
        if (this.mode != "zoom")
            this.triggerEvent("mapmove", {x: curx, y: cury});
    },
    object_jumpto: function (obj, ox, oy, curx, cury, stretch, xmax, ymax, xoffs, yoffs) {
        var xs = Math.floor((ox - curx) * stretch + xoffs + Math.round(this.mapw / 2));
        var ys = Math.floor((oy - cury) * stretch + yoffs + Math.round(this.maph / 2));
        if (xmax > 0) {
            xs = Math.max(xs, 0);
            ys = Math.max(ys, 0);
        }
        if ((xmax < 0) || ((xs < xmax) && (ys < ymax)))
            it_dom.moveto(obj, xs, ys);
        else
            it_dom.moveto(obj, 0, -1000);
    },
    is_visible: function (x, y) {
        return (x >= this.topx && x <= (this.topx + this.mapw) && y >= this.topy && y <= (this.topy + this.maph));
    },
    startzoom: function (zmx, zmy, zc, zt) {
        if (this.mode != "")
            return false;
        this.zoomtargetlevel = zt !== false ? zt : this.zi + (zc > 1 ? 1 : -1);
        if (this.zoomtargetlevel < 0 || this.zoomtargetlevel > this.env.zoommax)
            return false;
        this.starttime = it_now();
        this.zoommovex = zmx;
        this.zoommovey = zmy;
        this.setmode("zoom");
        this.triggerEvent("zoomstart", {zd: this.get_zd()});
        this.hide_tiles(0, false);
        this.clear_tiles();
        this.dozoom();
        return false;
    },
    dozoom: function () {
        var done = Math.min(it_now() - this.starttime, this.zoomtime) / this.zoomtime;
        var ox = Math.round(this.zoommovex * Math.sqrt(done));
        var oy = Math.round(this.zoommovey * Math.sqrt(done));
        this.jumpto(this.centerx + ox, this.centery + oy, 0, 0, 0, 0, 1 + done * (this.env.zoomlevels[this.zi] / this.env.zoomlevels[this.zoomtargetlevel] - 1), false);
        if (done >= 1) {
            if (this.dozoom_timer)
                this.dozoom_timer.stop();
            this.dozoom_timer = null;
            this.endzoom();
        } else if (!this.dozoom_timer)
            this.dozoom_timer = new it_timer({
                object: this,
                method: 'dozoom',
                continuous: true,
                timeout: 60 * this.x11factor
            });
    },
    endzoom: function () {
        this.centerx = this.p2p(this.centerx + this.zoommovex, this.zi, this.zoomtargetlevel);
        this.centery = this.p2p(this.centery + this.zoommovey, this.zi, this.zoomtargetlevel);
        this.circle_offset = [this.p2p(this.circle_offset[0], this.zi, this.zoomtargetlevel), this.p2p(this.circle_offset[1], this.zi, this.zoomtargetlevel)];
        if (this.popup_poi) {
            this.popup_poi.x = this.p2p(this.popup_poi.x, this.zi, this.zoomtargetlevel);
            this.popup_poi.y = this.p2p(this.popup_poi.y, this.zi, this.zoomtargetlevel);
            this.poi_mouset = it_now() + 1500;
        }
        this.zi = this.zoomtargetlevel;
        this.update_dyn_pois();
        this.finetune();
        this.preload();
        this.triggerEvent("zoomend", {zd: this.get_zd()});
        this.clippingchanged();
    },
    load_control: function () {
        if (this.mode == "preload" && this.preload_count <= 0 || it_now() > this.switch_hard) {
            it_dom.moveto(this.loading_img, 0, 1000 + this.maph);
            this.setmode("");
            this.preload_count = 0;
            this.clippingchanged();
            if (this.load_control_timer) {
                this.load_control_timer.stop();
                this.load_control_timer = null;
            }
        } else if (it_now() > this.show_loading_timeout && this.preload_count > 0)
            it_dom.moveto(this.loading_img, (this.mapw - 32) / 2, (this.maph - 32) / 2);
    },
    set_gui_elements: function () {
        if (!this.controls_box) {
            this.controls_box = it_create_element(this.mapcontainer, 'table', {className: 'controlsbox'});
            this.controls_box.setAttribute('width', 126);
            this.controls_box.appendChild(document.createElement('tbody'));
            this.controls_box.tBodies[0].appendChild(document.createElement('tr'));
            this.controls_box.rows[0].appendChild(document.createElement('td'));
        }
        this.update_zoombar();
        this.update_maptype();
        this.update_pantools();
        if (this.controls.zoom || this.controls.type || this.controls.pan)
            it_dom.show(this.controls_box);
        else
            it_dom.hide(this.controls_box);
        this.update_ruler();
        this.update_copyright();
        this.position_fade_obj();
    },
    update_zoombar: function () {
        if (this.controls.zoom) {
            if (!this.zoomtool_box) {
                this.zoomtool_box = it_create_element(this.controls_box.rows[0].cells[0], 'div',
                    {innerHTML: this.env.zoomtempl.replace(/%s/g, this.dom_id_prefix), className: 'zoomtools'});
                var elm, mapref = this;
                it_element(this.dom_id_prefix + 'zoomin').onclick = function (e) {
                    mapref.zoom(1);
                    search_unfocus(this);
                    return it_event_void(e)
                };
                it_element(this.dom_id_prefix + 'zoomout').onclick = function (e) {
                    mapref.zoom(-1);
                    search_unfocus(this);
                    return it_event_void(e)
                };
                for (var i = 0; i <= this.env.zoommax; i++) {
                    (elm = it_element(this.dom_id_prefix + 'azoomindex' + i))._zi = i;
                    elm.onclick = function (e) {
                        mapref.startzoom(0, 0, 0, this._zi);
                        search_unfocus(this);
                        return it_event_void(e)
                    };
                }
                this.set_mapcontrol_handlers(this.zoomtool_box);
            }
            for (var i = 0; i <= this.env.zoommax; i++)
                it_dom.set_class(this.dom_id_prefix + 'zoomindex' + i, (i == this.zi ? "zon" : "zoff"));
            it_element(this.dom_id_prefix + 'zoomin').src = this.service_url("/images/zoom_in" + (this.zi == this.env.zoommax ? "_disabled.gif" : ".gif"));
            it_element(this.dom_id_prefix + 'zoomout').src = this.service_url("/images/zoom_out" + (this.zi == 0 ? "_disabled.gif" : ".gif"));
            it_dom.set_style(this.zoomtool_box, 'display', 'block');
        } else if (this.zoomtool_box)
            it_dom.set_style(this.zoomtool_box, 'display', 'none');
    },
    update_maptype: function () {
        if (this.controls.type) {
            if (!this.maptype_box) {
                this.maptype_box = it_create_element(this.controls_box.rows[0].cells[0], 'div',
                    {innerHTML: this.env.typetempl.replace(/%s/g, this.dom_id_prefix), className: 'maptypebox'});
                var mapref = this;
                it_element(this.dom_id_prefix + 'tosym').onclick = function (e) {
                    mapref.set({type: 'street'});
                    search_unfocus(this);
                    return it_event_void(e)
                };
                it_element(this.dom_id_prefix + 'tofoto').onclick = function (e) {
                    mapref.set({type: 'aerial'});
                    search_unfocus(this);
                    return it_event_void(e)
                };
                this.set_mapcontrol_handlers(this.maptype_box);
            }
            var low = (this.bandwidth == 'low');
            var cn = it_element(this.dom_id_prefix + 'tosym').tagName == 'IMG' ? 'bandwimg' : 'bandwlink';
            it_dom.set_class(this.dom_id_prefix + 'tosym', cn + (low ? '_active' : ''));
            it_dom.set_class(this.dom_id_prefix + 'tofoto', cn + (!low ? '_active' : ''));
            it_dom.set_style(this.maptype_box, 'borderTopWidth', this.zoomtool_box ? '1px' : '0');
            it_dom.set_style(this.maptype_box, 'display', 'block');
        } else if (this.maptype_box)
            it_dom.set_style(this.maptype_box, 'display', 'none');
    },
    update_pantools: function () {
        if (this.controls.pan) {
            if (!this.pantools_box) {
                this.pantools_box = it_create_element(this.controls_box.rows[0], 'td',
                    {innerHTML: this.env.pantempl.replace(/%s/g, this.dom_id_prefix), className: 'pantools'});
                var elm = it_element(this.dom_id_prefix + 'panimg');
                it_add_event({element: elm, event: "mousedown", object: this, method: "pan_mousedown"});
                it_add_event({element: elm, event: "mouseup", object: this, method: "pan_mouseup"});
                this.set_mapcontrol_handlers(this.pantools_box);
            }
            it_dom.set_style(this.pantools_box, 'display', this.useragent.ie ? 'inline' : 'table-cell');
        } else if (this.pantools_box)
            it_dom.set_style(this.pantools_box, 'display', 'none');
    },
    update_ruler: function () {
        if (this.controls.ruler) {
            if (!this.ruler_box)
                this.ruler_box = it_create_element(this.mapcontainer, 'div',
                    {
                        style: {position: 'absolute', zIndex: 905, bottom: '0px', right: '0px', height: '20px'},
                        innerHTML: this.env.unittempl.replace(/%s/g, this.dom_id_prefix)
                    })
            var unit = this.env.unitlevels[this.zi];
            var rwidth = Math.round(unit / this.env.rect[this.zi]);
            try {
                it_element(this.dom_id_prefix + 'rulerimg').width = rwidth;
                it_element(this.dom_id_prefix + 'm2p').innerHTML = (unit >= 1000 ? unit / 1000 + " km" : unit + " m");
                it_dom.set_style(this.ruler_box, 'width', (rwidth + 4) + 'px');
                it_dom.set_style(this.ruler_box, 'display', 'block');
            } catch (e) {
            }
        } else if (this.ruler_box)
            it_dom.set_style(this.ruler_box, 'display', 'none');
    },
    update_links: function () {
        if (this.p.internal) {
            var links = {
                version_static: "s=1",
                printlink: "p=" + this.mapw + "x" + this.maph,
                emaillink: "e=1",
                bookmarklink: "",
                embedlink: "embed=1"
            }
            for (var link in links)
                it_element(link).href = this.get_perm_url(links[link]);
        } else
            it_element(this.dom_id_prefix + 'copyrightlink').href = this.getPermUrl();
    },
    update_copyright: function () {
        if (!this.copyright_box) {
            this.copyright_box = it_create_element(this.mapcontainer, 'div',
                {
                    style: {position: 'absolute', zIndex: 904, left: '0px', bottom: '0px', height: '15px'},
                    innerHTML: this.env.copyright.replace(/%s/g, this.dom_id_prefix)
                })
            it_element(this.dom_id_prefix + 'copyright').src = this.service_url(this.p.internal ? "/images/copyright.gif" : "/images/copyright2.gif");
        }
    },
    set_mapcontrol_handlers: function (elm) {
        var mapref = this;
        elm.onmouseover = function (e) {
            mapref.mouseout();
            return window.it_event_void ? it_event_void(e) : false;
        };
        elm.onmouseout = function (e) {
            mapref.mouseover();
            return window.it_event_void ? it_event_void(e) : false;
        };
    },
    position_fade_obj: function () {
        if (this.fade_obj && !this.fade_obj_shown++) {
            if (this.fade_obj.firstChild.offsetWidth > this.fade_obj.offsetWidth)
                it_dom.set_style(this.fade_obj, 'width', this.fade_obj.firstChild.offsetWidth + 'px');
            if (this.fade_obj.firstChild.offsetHeight > this.fade_obj.offsetHeight)
                it_dom.set_style(this.fade_obj, 'height', this.fade_obj.firstChild.offsetHeight + 'px');
            this.set_alpha(this.fade_obj, 0);
            it_dom.moveto(this.fade_obj, Math.ceil((this.mapw - parseInt(this.fade_obj.style.width)) / 2), Math.ceil((this.maph - parseInt(this.fade_obj.style.height)) / 2));
            it_dom.show(this.fade_obj);
            this.fade_obj_vis = true;
            this.fade_dir = 'in';
            new it_timer({object: this, method: 'fade', timeout: 200});
            it_element(this.dom_id_prefix + "popinbutton").focus();
        }
    },
    remove_fade_obj: function () {
        if (this.fade_obj) {
            this.mapcontainer.removeChild(this.fade_obj);
            this.fade_obj_vis = false;
            this.fade_obj_shown = 0;
            this.fade_obj = null;
        }
    },
    display_message: function (msg, show) {
        this.fade_obj = it_create_element(this.mapcontainer, 'div',
            {
                className: 'tooltip',
                style: {
                    position: 'absolute',
                    zIndex: 20000,
                    width: '300px',
                    height: '180px',
                    visibility: 'hidden',
                    opacity: 0.01
                },
                innerHTML: '<table class="tooltip_content" style="width:100%;height:170px;text-align:center;"><tr><td><br />' + msg + '</td></tr>' +
                    '<tr><td style="vertical-align:bottom; padding:1em"><input type="button" id="' + this.dom_id_prefix + 'popinbutton" style="width:7em" onclick="' + this.ref + '.fade_out()", value="OK" /></td></tr></table>'
            });
        if (show)
            this.position_fade_obj();
    },
    fade_out: function () {
        this.fade_dir = 'out';
        this.fade();
        this.triggerEvent("messageconfirm");
    },
    fade: function () {
        if (this.fade_start == 0)
            this.fade_start = it_now();
        var perc = (it_now() - this.fade_start) / this.fade_length;
        if (perc < 1) {
            this.set_alpha(this.fade_obj, (this.fade_dir == "in" ? perc : 1 - perc) * this.fade_max);
            if (!this.fade_timer)
                this.fade_timer = new it_timer({object: this, method: 'fade', continuous: true, timeout: 50});
        } else {
            if (this.fade_timer) {
                this.fade_timer.stop();
                this.fade_timer = 0;
            }
            this.set_alpha(this.fade_obj, (this.fade_dir == "in" ? this.fade_max : 0));
            if (this.fade_dir == "out")
                this.remove_fade_obj();
            this.fade_start = 0;
        }
    },
    set_alpha: function (obj, val) {
        val = Math.sin(1.5705 * val);
        if (obj && obj.style) {
            if (typeof obj.style.filter == "string")
                obj.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=" + Math.floor(val * 100) + ")";
            else if (obj.style.opacity)
                obj.style.opacity = val > 0 ? val : 0.01;
        }
    },
    update_poigroups: function (p, mode, redraw) {
        if (!this.poi_sticky && mode != 'set')
            this.poi = this.env.poi_defaults[this.zi];
        var pois = [];
        var pset = p.split(',');
        var current = it_array_flip(this.poi.split(','));
        var groups = it_array_flip(this.env.poicombine);
        for (var k = 0; k < pset.length; k++)
            if (groups[pset[k]])
                p += ',' + groups[pset[k]];
        var set = it_array_flip(p.split(','));
        for (var type, c = 0, i = 0; i < this.env.alltypes.length; i++) {
            type = this.env.alltypes[i];
            if ((mode == 'add' && (typeof current[type] != 'undefined' || typeof set[type] != 'undefined')) ||
                (mode == 'remove' && typeof current[type] != 'undefined' && typeof set[type] == 'undefined') ||
                (mode == 'set' && typeof set[type] != 'undefined'))
                pois[c++] = type;
        }
        if (set['default'])
            pois[c++] = "default";
        this.poi = pois.join(',');
        this.poi_sticky = true;
        this.popup_hide();
        if (redraw && (this.mode == "" || this.mode == "preload"))
            this.jumpto(this.centerx, this.centery, 0, 0, 0, 0, 1, false);
        this.triggerEvent("change", {poigroups: this.poi_compact(this.poi)});
    },
    poi_radardaemon: function () {
        this.poi_mousex = this.mousex + this.topx + (this.useragent.gecko ? 2 : 0);
        this.poi_mousey = this.mousey + this.topy + (this.useragent.gecko ? 2 : 0);
        var dx = this.poi_mousex - this.poi_oldmousex, dy = this.poi_mousey - this.poi_oldmousey,
            dt = this.poi_mouset - this.poi_oldmouset;
        if (dt > 0) {
            this.poi_speed = dt < 1000 ? Math.round(Math.sqrt(dx * dx + dy * dy) * 1000 / dt) : 999;
            this.poi_oldmousex = this.poi_mousex;
            this.poi_oldmousey = this.poi_mousey;
            this.poi_oldmouset = this.poi_mouset;
        } else if (it_now() - this.poi_mouset > 250)
            this.poi_speed = 0;
        if (this.active_events.pois && this.mode == "" && this.mousex < 9999 && (this.popup_checkposx != this.poi_mousex || this.popup_checkposy != this.poi_mousey) && this.poi_speed < 40) {
            this.popup_checkposx = this.poi_mousex;
            this.popup_checkposy = this.poi_mousey;
            this.poi_trigger();
        }
    },
    poi_trigger: function () {
        this.poi_findpopup();
        this.popup_check();
        if (this.poi_wannaload != this.poi_requested) {
            this.loader.clear();
            this.loader.load(this.poi_requested = this.poi_wannaload, 0, 10, '&timestamp=' + it_now());
        }
    },
    popup_check: function () {
        if (!this.popup_mouseinside() && !(this.showing_dyn_poi && this.showing_dyn_poi.sticky))
            this.popup_hide();
    },
    poi_findpopup: function () {
        if (this.showing_dyn_poi || this.popup_mouseinside() || !this.map_mouseinside)
            return;
        var rough = this.env.publictelparams ? 128 : 512;
        var poi_grid = this.env.zoomlevels[this.zi] <= 4 ? rough : 32;
        var gx = Math.floor((this.poi_mousex + poi_grid / 2) / poi_grid);
        var gy = Math.floor((this.poi_mousey + poi_grid / 2) / poi_grid);
        var poi_url = this.service_url("/poitext." + this.env.language + ".php?language=" + this.env.language + "&gx=" + gx + "&gy=" + gy + "&zd=" + this.env.zoomlevels[this.zi] + this.coord_base + (this.p.drawing ? "&d=" + this.p.drawing : "") + "&grid=" + poi_grid + "&poi=" + this.poi_compact(this.poi_active()) + (this.env.poi_src_add ? this.env.poi_src_add : '') + '&charset=' + this.charset, true);
        var mindist = 999, bestentry, bestentry_count = 0, bestentry_id;
        if (typeof (this.poi_packed[poi_url]) == 'undefined')
            this.poi_wannaload = poi_url;
        else {
            if (this.poi_unpacked_url != poi_url) {
                this.poi_unpacked = this.poi_packed[this.poi_unpacked_url = poi_url].split("\t");
                this.poi_shown = -1;
            }
            for (var i = 0; i < this.poi_unpacked.length; i += 3) {
                if (typeof this.poi_unpacked[i] != 'undefined') {
                    var dx = this.poi_unpacked[i] - this.poi_mousex, dy = this.poi_unpacked[i + 1] - this.poi_mousey,
                        dist = dx * dx + dy * dy;
                    if (dist < mindist) {
                        mindist = dist, bestentry = {
                            x: this.poi_unpacked[i] - 0,
                            y: this.poi_unpacked[i + 1] - 0,
                            html: this.poi_unpacked[i + 2]
                        };
                        bestentry_count = 0;
                        bestentry_id = i;
                    } else if (bestentry && dist <= mindist + 4 && (bestentry.html.indexOf(this.poi_unpacked[i + 2]) == -1) && bestentry_count < 5) {
                        bestentry.html += "|" + this.poi_unpacked[i + 2];
                        bestentry_count++;
                    }
                }
            }
            if ((this.poi_shown != bestentry_id) && (Math.sqrt(mindist) <= Math.max(8, this.env.poidir[this.zi] / 2))) {
                this.poi_shown = bestentry_id;
                this.popup_poi = bestentry;
                this.popup_show();
            }
        }
    },
    poi_active: function () {
        var ret = this.poi_sticky ? this.poi : this.env.poi_defaults[this.zi];
        return ret ? ret : "";
    },
    poi_compact: function (poi) {
        for (var from in this.env.poicombine)
            poi = poi.replace(new RegExp(from), this.env.poicombine[from]);
        return poi;
    },
    popup_show: function () {
        if (this.showing_dyn_poi && this.dynpois[this.showing_dyn_poi.id])
            this.popup_poi = this.dynpois[this.showing_dyn_poi.id];
        if (!this.popup_poi)
            return;
        var offx = 0, offy = 0;
        var pop_x = this.popup_poi.x, pop_y = this.popup_poi.y;
        var poi_html = typeof this.popup_poi.render == 'function' ? this.popup_poi.render() : this.popup_poi.html;
        if (!poi_html)
            return;
        if (!this.popup)
            this.popup = it_create_element(this.mapcontainer, 'div', {
                style: {
                    position: 'absolute',
                    zIndex: 1000,
                    left: '-1000px',
                    textAlign: 'left'
                }
            });
        if (typeof this.popup_poi.render_dom == 'function')
            this.popup_poi.render_dom(this.popup);
        else
            this.popup_render(poi_html);
        this.popup_bar = 0;
        var height = this.popup.scrollHeight;
        if (height > this.maph * this.popup_maxheight) {
            this.popup.style.height = (height = Math.floor(this.maph * this.popup_maxheight * 0.9)) + "px";
            this.popup.style.overflow = "scroll";
            this.popup_bar = 15;
        }
        var width = this.popup.scrollWidth;
        if (width > this.mapw * this.popup_maxwidth) {
            this.popup.style.width = (width = Math.floor(this.mapw * this.popup_maxwidth * 0.9)) + "px";
            this.popup.style.overflow = "scroll";
            this.popup_bar = 15;
        }
        if (width) {
            offx = width + ((pop_x - this.centerx) + this.mapw / 2) - this.mapw + 1 + this.popup_bar;
            offy = ((pop_y + 12 - this.centery) + height > this.maph / 2) ? (height + 24) : 0;
        }
        this.object_jumpto(this.popup, pop_x, pop_y + 12, this.centerx + (offx > 0 ? offx : 0), this.centery + (offy > 0 ? offy : 0), 1, this.mapw, this.maph, 0, 0);
        this.popup_showtime = it_now();
    },
    popup_render: function (text) {
        var dupes_allowed = {maplink: 1, stau: 1, baustelle: 1, verwaltung: 1, schule: 1};
        var a = text.split("\|"), htm = "", opaque = "";
        var entries = new Object;
        var label, foo, key, j, title, cats;
        for (var i = 0; i < a.length; i += 2) {
            label = a[i];
            foo = 0;
            key = (label == "business" || label == "person") ? a[i + 1].match(/[0-9\s]{8,}/) + ":" + i : (dupes_allowed[label] ? label + i : label);
            if (a[i + 1] && a[i + 1].match(/\{\{/))
                a[i + 1] = this.timetable(a[i + 1]);
            cats = String(label).split(',');
            for (j = 0; j < cats.length; j++) {
                label = cats[j];
                cats[j] = this.env.text[label] ? this.env.text[label] : (this.env.text[label.replace(/_.*/, "")] ? this.env.text[label.replace(/_.*/, "")] : (a[i + 1] ? label : ''));
            }
            title = label ? cats.join(', ') : '';
            entries[key] = (title ? '<tr><td class="tooltip_title">' + title + '</td></tr>' : '')
                + '<tr><td class="tooltip_content">' + (a[i + 1] ? a[i + 1] : a[i]).replace(/\{MAPINSTANCE\}/g, this.ref) + '</td></tr>'
                + (a[i + 2] ? '<tr><td></td></tr>' : '');
        }
        for (i in entries)
            htm += entries[i];
        if (htm.match("<img"))
            opaque = ' opaque';
        if (this.useragent.iphone)
            htm = htm.replace(/href="http:\/\/tel.[a-z\.]+\/voip\.html\?tel=0([0-9]+)"/, 'href="tel:+41$1"');
        try {
            this.popup.innerHTML = '<table class="tooltip' + opaque + '">' + htm + '</table>';
        } catch (e) {
        }
    },
    popup_hide: function () {
        if (this.popup && this.popup_poi) {
            this.poi_shown = -1;
            it_dom.moveto(this.popup, -2000, 0);
            if (typeof this.popup_poi.hide_popup == 'function')
                this.popup_poi.hide_popup();
            if (this.dynpoi_timer)
                this.dynpoi_timer.stop();
            this.popup_poi = this.showing_dyn_poi = null;
            try {
                this.popup.style.overflow = this.popup.style.height = this.popup.style.width = "";
                this.popup.innerHTML = "";
            } catch (e) {
            }
        } else if (this.showing_dyn_poi)
            this.showing_dyn_poi = null;
    },
    popup_mouseinside: function (nopadding) {
        var result = this.fade_obj_vis;
        if (this.popup && this.popup_poi) {
            var pl = this.popup.offsetLeft;
            var pr = pl + this.popup.offsetWidth;
            var pt = this.popup.offsetTop;
            var pb = pt + this.popup.offsetHeight;
            var s = Math.ceil(this.env.poidir[this.zi] / 2);
            var pad = nopadding ? 0 : 4;
            result = (!nopadding && this.poi_mousex >= this.popup_poi.x - s && this.poi_mousex <= this.popup_poi.x + s && this.poi_mousey >= this.popup_poi.y - s && this.poi_mousey <= this.popup_poi.y + s) ||
                (this.mousex >= pl - pad && this.mousex <= pr + pad && this.mousey >= pt - pad && this.mousey <= pb + pad);
        }
        return result;
    },
    set_dyn_poi: function (p) {
        var poi;
        if (!(poi = this.dynpois[p.id]) || !poi.p)
            return;
        if (p.method) {
            if (p.error) {
                this.alert(poi.p.center + ':\n' + p.error);
                return;
            }
            poi.x = p.x;
            poi.y = p.y;
            poi.px = this.p2p(p.x, this.zi, this.env.zoommax);
            poi.py = this.p2p(p.y, this.zi, this.env.zoommax);
            poi.p.enabled = p.enabled;
            poi.ready = true;
        }
        if (!poi.ready && (typeof poi.p.center == 'object' || typeof poi.p.center == 'string')) {
            this.geocoder.m2p(poi.p.center, {method: 'set_dyn_poi', id: poi.id, enabled: poi.p.enabled});
            return;
        }
        if (!poi.icon)
            poi.create_icon(this);
        poi.maxzi = poi.p.maxzoom ? this.zd2zi(poi.p.maxzoom) : 0;
        poi.minzi = poi.p.minzoom ? this.zd2zi(poi.p.minzoom) : this.env.zoommax;
        if (this.zi >= poi.maxzi && this.zi <= poi.minzi) {
            this.object_jumpto(poi.icon, poi.x, poi.y, this.centerx, this.centery, 1, -1, -1, -poi.offsetx, -poi.offsety);
            poi.show();
        } else
            poi.hide();
    },
    popup_dyn_poi: function (poi, sticky) {
        if (poi && this.dynpois[poi.id] && !(this.showing_dyn_poi && this.showing_dyn_poi.id == poi.id)) {
            this.hide_dyn_poi();
            poi.x = this.p2p(poi.px);
            poi.y = this.p2p(poi.py);
            if (!this.is_visible(poi.x, poi.y)) {
                var xoff = Math.floor(this.mapw / 3);
                var yoff = Math.floor(this.maph / 3);
                this.moveto({
                    x: poi.x < this.topx ? poi.x + xoff : (poi.x > this.topx + this.mapw ? poi.x - xoff : this.centerx),
                    y: poi.y < this.topy ? poi.y + yoff : (poi.y > this.topy + this.maph ? poi.y - yoff : this.centery)
                });
            }
            this.showing_dyn_poi = {id: poi.id, sticky: true, keep: sticky};
            this.dynpoi_timer = new it_timer({object: this, method: 'popup_show', timeout: 200});
        }
    },
    cancel_dyn_poi: function () {
        if (this.dynpoi_timer)
            this.dynpoi_timer.stop();
        if (this.showing_dyn_poi && !this.showing_dyn_poi.keep)
            this.showing_dyn_poi.sticky = false;
    },
    hide_dyn_poi: function () {
        if (this.showing_dyn_poi) {
            if (this.dynpoi_timer)
                this.dynpoi_timer.stop();
            this.showing_dyn_poi = null;
            this.popup_hide();
        }
    },
    update_dyn_pois: function () {
        var dyn;
        for (var id in this.dynpois) {
            if ((dyn = this.dynpois[id]) && dyn.ready && dyn.icon) {
                dyn[(this.zi >= dyn.maxzi && this.zi <= dyn.minzi ? 'show' : 'hide')]();
            }
        }
    },
    timetable: function (str) {
        var m = this;
        var parts;
        if (!(parts = str.match(/^(.*)(\{\{.*\}\}.*)$/)))
            return str;
        if (window.SearchChIPhoneApp) {
            var data = parts[2].match(/^\{\{(.*)\}\}(.*)$/);
            var dests = data[1].split("#");
            return parts[1] + '<a href="app://oev/' + dests[0] + '" class="tttitle">' + dests[0] + '</a>';
        }
        if (!this.tt) {
            this.tt = new oev_timetable({
                disp: 0, laterlines: 1, arrows: 1, save_func: function (tt, key, value) {
                    m.persistent('tt_' + key, value)
                }, env: this.env
            });
            this.tt.surroundingform = document.f;
        }
        this.tt.load({data: parts[2]});
        return parts[1] + this.tt.get_title() + this.tt.get_timetable() + '<div class="ttform">' + this.tt.get_form() + '<\/div>';
    },
    persistent: function (key, val) {
        if (!key)
            return;
        if (!this.persistentimg)
            this.persistentimg = new Image();
        this.persistentimg.src = this.service_url('/persistent.gif?' + key + '=' + it_url_encode(val));
        this.env[key] = val;
    },
    sendaudit: function () {
        var auditimg = new Image();
        if (!this.env.noads)
            auditimg.src = 'http://www.search.ch/audit/CP/map/' + this.env.language + '/' + '?tm=' + (this.readytime - this.startuptimestamp);
    },
    loadcss: function (url) {
        if (SearchChMap.cssloaded)
            return;
        if (document.createStyleSheet) {
            document.createStyleSheet(this.service_url('/itjs/mapwidget.css'));
        } else {
            it_create_element(document.getElementsByTagName("head")[0], 'link',
                {
                    rel: 'stylesheet',
                    href: 'data:text/css,' + escape("@import url('" + this.service_url('/itjs/mapwidget.css') + "');")
                });
        }
        SearchChMap.cssloaded = true;
    },
    pngfix: function (img, w, h) {
        var old_IE = navigator.platform == "Win32" && String(navigator.userAgent).match(/MSIE ((5\.5)|6)/);
        if (old_IE && img.src && (img.src.match(/\.png($|\?)/) || img.src.match(/&d=[a-z0-9_-]+/))) {
            it_dom.resizeto(img, (w || img.width), (h || img.height));
            img.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + img.src + "',sizingMethod='crop')";
            img.src = this.service_url('/images/0.gif');
        } else if (img && old_IE)
            it_dom.set_style(img, 'filter', 'none');
    },
    destroy: function () {
        it_remove_event({element: document, event: "mouseup", object: this, method: "mouseup"});
        SearchChMap.instances[this.id] = null;
    },
    fatal: function (msg) {
        this.is_error = true;
        this.alert(msg);
    },
    alert: function (msg) {
        alert(msg);
    }
}
SearchChMap.prototype.addEventListener = SearchChEvent.prototype.addEventListener;
SearchChMap.prototype.removeEventListener = SearchChEvent.prototype.removeEventListener;
SearchChMap.prototype._triggerEvent = SearchChEvent.prototype.triggerEvent;
SearchChMap._onload = function () {
    for (var id in SearchChMap.instances)
        if (SearchChMap.instances[id] && (typeof SearchChMap.instances[id] == 'object') && SearchChMap.instances[id].p && SearchChMap.instances[id].p.autoload)
            SearchChMap.instances[id].init();
    SearchChMap.pageloaded = true;
}
it_add_event({element: window, event: "load", object: SearchChMap, method: "_onload"});
if (!window.SearchChMap)
    window.SearchChMap = {};
SearchChMap.isBrowserCompatible = function () {
    var ua;
    if (!(ua = SearchChMap.user_agent))
        SearchChMap.user_agent = ua = new search_user_agent();
    return (!ua.iemac && ua.dom && !((ua.konqueror && ua.konqueror < 3.2) || (ua.safari && ua.safari <= 120)));
};
SearchChMap.isDrawingSupported = function () {
    var comp = SearchChMap.isBrowserCompatible();
    var ua = SearchChMap.user_agent;
    return comp && (ua.ie || (ua.opera >= 9) || (ua.gecko >= 1.8) || (ua.safari >= 412));
};
if (SearchChMap.isBrowserCompatible()) {
    document.documentElement.className += ' compatible';
    if (!location.href.match(/[&?](s|embed)=1/))
        document.documentElement.className += ' interactive'
}
if (SearchChMap.isDrawingSupported())
    document.documentElement.className += ' drawable';
if (navigator.geolocation)
    document.documentElement.className += ' geolocation';

function GeoCoder(map, buf) {
    this.map = map;
    this.buffering = buf;
    this.requests = [];
    this.cache = {};
    this.querylen = 0;
}

GeoCoder.prototype = {
    m2p: function (m, callback) {
        if (!callback) callback = {};
        var cache_key = this.map.base + ":z" + this.map.zi + ":";
        var address = m;
        if (typeof m == 'string') {
            address = m.replace(/;/, '');
            cache_key += m;
        } else if (m.length) {
            address = m.join(',');
            cache_key += address;
        }
        if (typeof m.px != 'undefined' && typeof m.py != 'undefined') {
            callback.x = this.map.p2p(m.px);
            callback.y = this.map.p2p(m.py);
        } else if (this.cache[cache_key])
            it_set(callback, this.cache[cache_key]);
        if (this.map.transform)
            this.local_m2p(m, callback);
        if (typeof callback.x != 'undefined' && typeof callback.y != 'undefined') {
            if (callback.method)
                this.map[callback.method](callback);
        } else {
            this.requests[this.requests.length] = {query: address, callback: callback, cache: cache_key, state: 0};
            this.querylen += it_url_encode(address).length + 4;
            if (!this.buffering || this.querylen > 1000)
                this.flush(this.buffering);
        }
    },
    local_m2p: function (m, result) {
        var transform = this.map.transform && this.map.transform[this.map.zi];
        if (transform && (typeof m == 'object') && m.length == 2) {
            if (!isNaN(m[0]) && m[0] < 180)
                m = this.wgs2swiss(m[1], m[0]);
            if (!isNaN(m[0])) result.x = (m[0] - transform[1]) / transform[0];
            if (!isNaN(m[1])) result.y = (m[1] - transform[3]) / transform[2];
        }
    },
    wgs2swiss: function (lon, lat) {
        if (lon > 20) {
            var tmp = lon;
            lon = lat;
            lat = tmp;
        }
        var lams = (lon * 3600 - 26782.5) / 10000;
        var lams2 = lams * lams;
        var lams3 = lams2 * lams;
        var phis = (lat * 3600 - 169028.66) / 10000;
        var phis2 = phis * phis;
        var phis3 = phis2 * phis;
        return [
            Math.round(600072.37 + 211455.93 * lams - 10938.51 * lams * phis - 0.36 * lams * phis2 - 44.54 * lams3),
            Math.round(200147.07 + 308807.95 * phis + 3745.25 * lams2 + 76.63 * phis2 - 194.56 * lams2 * phis + 119.79 * phis3)
        ];
    },
    flush: function (buff) {
        var lookups = [];
        var ids = [];
        for (var i = 0; i < this.requests.length; i++) {
            if (this.requests[i] && this.requests[i].query && this.requests[i].state == 0) {
                lookups[lookups.length] = this.requests[i].query;
                ids[ids.length] = i;
                this.requests[i].state = 1;
            }
        }
        if (lookups.length) {
            var req = {
                base: this.map.base,
                coord_base: this.map.coord_base,
                zd: this.map.get_zd(),
                batch: lookups.join(';'),
                seq: ids.join(';')
            };
            it_http.post(this.map.service_url("/api/?action=m2p", true), req, {object: this, method: 'response'});
        }
        this.querylen = 0;
        this.buffering = (typeof buff == 'undefined' ? false : buff);
    },
    cleanup: function () {
        var alldone = true;
        for (var i = 0; i < this.requests.length; i++)
            if (this.requests[i].state < 2)
                alldone = false;
        if (alldone)
            this.requests = [];
    },
    resolve: function (px, py, callback) {
        var idx = this.requests.length;
        this.requests[idx] = {callback: callback, state: 1};
        var req = {base: this.map.base, coord_base: this.map.coord_base, zd: this.map.get_zd(), x: px, y: py, seq: idx};
        it_http.post(this.map.service_url("/api/?action=resolve", true), req, {object: this, method: 'response'});
    },
    lookup: function (q, accuracy, callback) {
        var idx = this.requests.length;
        this.requests[idx] = {callback: callback, state: 1};
        var center = (typeof q == 'string') ? q : q.join(',');
        var req = {
            base: this.map.base,
            coord_base: this.map.coord_base,
            zd: this.map.get_zd(),
            latlon: center,
            accuracy: accuracy,
            seq: idx
        };
        it_http.post(this.map.service_url("/api/?action=resolve", true), req, {object: this, method: 'response'});
    },
    response: function (data) {
        if (data.request == 'm2p') {
            var request, result;
            for (var i in data.resolved) {
                result = data.resolved[i];
                if (!(request = this.requests[i]) || !request.callback)
                    continue;
                this.cache[request.cache] = {};
                it_set(this.cache[request.cache], result);
                it_set(request.callback, result);
                if (request.callback.method)
                    (request.callback.object ? request.callback.object : this.map)[request.callback.method](request.callback);
                this.requests[i].state = 2;
            }
            this.cleanup();
        } else if (data.request == 'resolve') {
            var request = this.requests[data.seq];
            if (request) {
                it_set(request.callback, data);
                if (request.callback.method)
                    (request.callback.object ? request.callback.object : this.map)[request.callback.method](request.callback);
                request.state = 2;
                this.cleanup();
            }
        }
    }
};

function SearchChPOI(p) {
    this.id = typeof p.id != 'undefined' ? p.id : SearchChPOI.instances.length;
    this.opened = false;
    this.p = {enabled: true, html: '', icon: 'http://map.search.ch/images/icons/17/p0.gif'};
    this.ref = 'SearchChPOI.instances[' + this.id + ']';
    this.icon = null;
    this.map = null;
    this.maxzi = 0;
    this.minzi = 9;
    this.iwidth = 21;
    this.iheight = 21;
    this.offsetx = 11;
    this.offsety = 11;
    this.visible = true;
    this.ready = false;
    this._events = {};
    this.x = this.y = 0;
    this.px = this.py = 0;
    this.set(p);
    SearchChPOI.instances[this.id] = this;
}

SearchChPOI.prototype = {
    set: function (p) {
        var updates = {};
        for (var k in p)
            if ((typeof this.p[k] == "undefined") || (this.p[k] != p[k]))
                updates[k] = true;
        if (p.center && typeof p.center == 'object')
            this.p.center = [];
        if (p.offset && typeof p.offset == 'object')
            this.p.offset = [];
        it_set(this.p, p);
        if (p.center && this.map) {
            this.ready = false;
            this.map.set_dyn_poi({id: this.id});
        } else if ((updates.minzoom || updates.maxzoom) && this.map)
            this.map.set_dyn_poi({id: this.id});
        if (p.width && !isNaN(p.width)) {
            this.iwidth = parseInt(p.width);
            this.offsetx = Math.floor(p.width / 2);
        }
        if (p.height && !isNaN(p.height)) {
            this.iheight = parseInt(p.height);
            this.offsety = Math.floor(p.height / 2);
        }
        if (updates.icon) {
            if (this.icon) {
                this.icon.src = this.p.icon;
                if (this.p.width && this.p.height)
                    it_dom.resizeto(this.icon, this.p.width, this.p.height);
            }
            var _poi = this;
            this.img = new Image();
            this.img.onload = function () {
                _poi.icon_loaded();
            };
            this.img.src = this.p.icon;
        }
        if (p.offset) {
            this.offsetx = this.p.offset[0];
            this.offsety = this.p.offset[1];
        }
        if (updates.enabled && !p.enabled && this.opened)
            this.close();
    },
    open: function (sticky) {
        if (this.map && this.ready) {
            this.map.popup_dyn_poi(this, sticky);
            if (this.map.active_events.clickpoi)
                new it_timer({object: this.map, method: 'cancel_dyn_poi', timeout: 300});
        }
    },
    close: function () {
        if (this.map && this.ready)
            this.map.hide_dyn_poi();
    },
    show: function () {
        if (this.icon)
            it_dom.show(this.icon);
        this.visible = true;
    },
    hide: function () {
        if (this.icon)
            it_dom.hide(this.icon);
        this.visible = false;
    },
    isVisible: function () {
        if (this.map && this.icon && this.visible) {
            var bbox = this.map.get_boundingbox();
            return (this.x >= bbox.x1 && this.y >= bbox.y1 && this.x <= bbox.x2 && this.y <= bbox.y2);
        } else
            return false;
    },
    create_icon: function (map) {
        if (this.icon)
            return;
        var _poi = this;
        this.icon = it_create_element(map.mapcontainer, 'img',
            {
                style: {
                    position: 'absolute',
                    left: '0px',
                    top: '-1000px',
                    width: this.p.width && !isNaN(this.p.width) ? this.p.width + 'px' : 'auto',
                    height: this.p.height && !isNaN(this.p.height) ? this.p.height + 'px' : 'auto',
                    border: 'none transparent 1px',
                    zIndex: 400,
                    visibility: (this.visible ? 'inherit' : 'hidden')
                },
                src: this.p.icon,
                oncontextmenu: function () {
                    return false;
                },
                onmouseover: function (e) {
                    _poi.mouseover(e);
                },
                onmouseout: function (e) {
                    _poi.mouseout(e);
                },
                onclick: function (e) {
                    _poi.mouseclick(e);
                },
                onerror: function (e) {
                    _poi.map.alert("Error loading icon " + this.src + ", using default icon.");
                    this.src = "http://map.search.ch/images/icons/21/p1.gif";
                }
            });
        this.map = map;
        this.ready = true;
        this.pngfix();
    },
    render: function () {
        this.opened = true;
        this.triggerEvent("popupopen", this);
        return (this.p.title ? this.p.title + '|' : '') + this.p.html;
    },
    hide_popup: function () {
        this.opened = false;
        this.triggerEvent("popupclose", this);
    },
    moveto: function (pos) {
        if (!this.icon)
            return;
        if (typeof pos.px != 'undefined' && typeof pos.py != 'undefined') {
            this.px = pos.px;
            this.py = pos.py;
            this.setpos(this.map.p2p(pos.px), this.map.p2p(pos.py));
        } else
            this.set({center: pos});
    },
    destroy: function () {
        if (this.map)
            this.map.removePOI(this.id);
        SearchChPOI.instances[this.id] = null;
    },
    mouseover: function (e) {
        if (this.p.enabled) {
            if (!this.map.active_events.clickpoi)
                this.open();
            this.triggerEvent("mouseover", this);
        }
    },
    mouseout: function (e) {
        if (this.map && !this.map.active_events.clickpoi)
            this.map.cancel_dyn_poi();
        if (this.p.enabled)
            this.triggerEvent("mouseout", this);
    },
    mouseclick: function (e) {
        if (this.p.enabled) {
            if (this.map.active_events.clickpoi)
                this.open();
            this.triggerEvent("mouseclick", this);
        }
    },
    icon_loaded: function () {
        var changed = this.img.width != this.iwidth || this.img.height != this.iheight;
        this.iwidth = this.img.width;
        this.iheight = this.img.height;
        if (!this.p.offset && !this.p.width && !this.p.height) {
            this.offsetx = Math.floor(this.iwidth / 2);
            this.offsety = Math.floor(this.iheight / 2);
        }
        if (this.icon && this.ready && changed)
            this.setpos(this.x, this.y);
        this.pngfix();
    },
    setpos: function (x, y) {
        this.x = x;
        this.y = y;
        this.map.object_jumpto(this.icon, this.x, this.y, this.map.centerx, this.map.centery, 1, -1, -1, this.iwidth / -2, this.iheight / -2);
    },
    pngfix: function () {
        var old_IE = navigator.platform == "Win32" && String(navigator.userAgent).match(/MSIE ((5\.5)|6)/);
        if (this.icon && this.icon.src.match(/\.png($|\?)/) && old_IE) {
            it_dom.resizeto(this.icon, this.iwidth, this.iheight);
            this.icon.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + this.icon.src + "',sizingMethod='crop')";
            this.icon.src = this.map.service_url('/images/0.gif');
        } else if (this.icon && old_IE)
            it_dom.set_style(this.icon, 'filter', 'none');
    }
}
SearchChPOI.instances = [];
SearchChPOI.prototype.addEventListener = SearchChEvent.prototype.addEventListener;
SearchChPOI.prototype.removeEventListener = SearchChEvent.prototype.removeEventListener;
SearchChPOI.prototype.triggerEvent = SearchChEvent.prototype.triggerEvent;

function oev_timetable(p) {
    if (!oev_timetable.idcount)
        oev_timetable.idcount = 0;
    this.id = oev_timetable.idcount++;
    this.data = "";
    this.parts = [];
    this.here = "";
    this.timebase = 0;
    this.with_arrows = p.arrows ? true : false;
    this.display = p.disp ? p.disp : 0;
    this.timeoffset = p.offset ? p.offset : 0;
    this.laterlines = typeof (p.laterlines) != 'undefined' ? p.laterlines : true;
    this.editmode = false;
    this.excludes = {};
    this.hide_boxes = {};
    this.env = p.env ? p.env : window.env;
    this.sbb_base = this.env.sbburl ? this.env.sbburl : "http://fahrplan.sbb.ch/bin/bhftafel.exe/dn";
    this.sbb_param = "?boardType=dep&REQProduct_list=1%3A1111111111000000&maxJourneys=20&start=1&distance=1";
    this.timetableurl = this.env.timetableurl ? this.env.timetableurl : "/";
    this.home = this.env.tt_home ? this.env.tt_home : "";
    this.sorting = this.env.tt_sort ? this.env.tt_sort : 0;
    this.maxtimes = p.maxtimes ? p.maxtimes : 2;
    this.tt_long = false;
    this.ua = String(navigator.userAgent);
    this.saveconfig_wrapper = typeof (p.save_func) == 'function' ? p.save_func : null;
    this.body = 'tt' + this.id + 'body';
    this.container = p.elem;
    this.instance = 'tti' + this.id;
    window[this.instance] = this;
    this.load(p);
}

oev_timetable.prototype = {
    load: function (p) {
        this.tt_long = false;
        this.data = p.data ? p.data : "";
        this.parts = this.data.match(/^\{\{(.*)\}\}(.*)$/);
        if (this.parts) {
            var dests = this.parts[1].split("#");
            this.here = dests[0];
            this.timebase = dests[1];
            this.station_id = dests[2];
        }
        if (p.exclude && typeof p.exclude == 'object')
            for (var i = 0; i < p.exclude.length; i++)
                this.excludes[p.exclude[i]] = 1;
        if (p.refresh)
            this.start_timer();
    },
    get_title: function () {
        var sbblnk = '<a target="_parent" href="' + this.sbb_base + this.sbb_param + '&input=' + escape(this.here) + '&selectDate=today&time=now">' + this.env.text.sbblnk + '</a>';
        return this.here ? '<table class="nude tttop"><tr><td class="tttitle">' + this.here + '</td><td class="ttsbb">' + sbblnk + '</td></tr></table>' : "";
    },
    get_timetable: function (innerhtml) {
        var parts;
        this.hide_boxes = {};
        if (!(parts = this.parts))
            return "";
        var dests = parts[1].split("#"), ret = [], retlen = 0;
        var seen = new Object(), html = new Array(), t = this.env.text;
        var arrows = [8594, 8599, 8593, 8598, 8592, 8601, 8595, 8600];
        var now = new Date();
        var mytime = Math.floor((now.getTime() / 1000 - this.timebase) / 60);
        var tb = new Date(this.timebase * 1000), timoffs = tb.getHours();
        var lng, subkey = 0, tmp, morelabel = 'laterlines';
        for (var d = 2; d < dests.length; d++) {
            var info = dests[d].split("~");
            if (!info[4])
                continue;
            var id = info[5] + '.' + (info[4].charCodeAt(0) + 33 * (info[4].charCodeAt(1) + 33 * info[3]));
            if (!this.editmode && this.excludes && this.excludes[id])
                continue;
            var numeric = info[5].match(/[0-9]/), i, tim = 0, departs = '', ndep = 0;
            var wid = info[4] == 'tra' && info[5].length < 3 ? ';width:1.7em' : ';width:2.5em';
            var style = info[0].length > 1 ? ' style="background-color:#' + info[0] + '; color:#' + info[1] + wid + (info[2] ? ';border:1px solid black' : '') + '"' : "";
            var ttbl = info[7], len = ttbl.length, dirkey = info[4] + (numeric ? info[5] : info[5] + info[6]) + info[3];
            var title = t['type_' + info[4]] ? ' title="' + t['type_' + info[4]] + '"' : '';
            var sortkey, startin = 9000, moreshown = 0, dd, rel, ddtip = "", arrow, t_arrow = t.arrow, last;
            if (!info[3] || !this.with_arrows) {
                arrow = '&nbsp;';
                t_arrow = "";
            } else if (this.ua.match(/Konqueror/) || this.ua.match(/NT 5\.0/))
                arrow = '<img src="/images/icons/dir/' + info[3] + '.gif" width="11" height="11" alt="" />';
            else
                arrow = '&#' + arrows[info[3]] + ';';
            for (i = 0; i < len; i++) {
                if (ttbl.charAt(i) == '+')
                    tim += 60;
                else if (ttbl.charAt(i) == '-')
                    ;
                else {
                    tim += ttbl.charCodeAt(i) - 48;
                    if (tim >= mytime) {
                        rel = (tim - mytime) - (this.display == 2 ? this.timeoffset : 0);
                        dd = ((100 + Math.floor(tim / 60 + timoffs) % 24) + "").substr(1) + ':' + ((100 + tim % 60) + "").substr(1);
                        if (dd == last || rel <= 0)
                            continue;
                        if (rel < startin)
                            startin = rel;
                        if (++ndep <= this.maxtimes) {
                            departs += (departs ? ",&nbsp;" : "");
                            if (this.display == 0)
                                departs += dd;
                            else {
                                ddtip += (ddtip ? ", " : "") + dd;
                                departs += ((100 + Math.floor(rel / 60) % 24) + "").substr(2) + ':' + ((100 + rel % 60) + "").substr(1);
                            }
                        } else if (ndep <= 5)
                            ddtip += (ddtip ? " " : "... ") + dd;
                        else
                            break;
                        last = dd;
                    }
                }
            }
            if (startin < 60 && info[4] != "etrn")
                sortkey = 100000 + startin;
            else if (startin < 60 || (info[8] != "1" && (startin < 300 || numeric)) || info[4].match(/^n_/)) {
                sortkey = 500000 + startin + (startin == 9000 && info[4].substr(0, 2) == "n_" ? 1 : 0);
                if (info[4] == 'etrn')
                    morelabel = 'longdist';
            } else
                sortkey = 999999;
            var cat = sortkey.toString().substr(0, 1);
            if (this.sorting == 0) {
                subkey = info[5] >= "0" && info[5] <= "9" ? info[5] : (tmp = info[5].match(/(\d+)/)) ? 1000 + 1 * tmp[0] : 2000 + info[5].charCodeAt(0);
                subkey += info[4].substr(0, 2) == "n_" ? 2000 : 0;
                subkey = cat + (100 * subkey + info[3] * 10 + (startin < 10 ? startin : 9) + 100000);
            } else if (this.sorting == 1)
                subkey = sortkey;
            else
                subkey = cat + info[6].substr(0, 16);
            if (!departs)
                departs = '<span title="' + t.nottoday + '">-</span>';
            info[5] = info[5].replace(/ /g, '&nbsp;');
            if (sortkey < 999999) {
                ret[retlen++] = sortkey + '|' + dirkey + '|' + info[8] + '|<tr><td id="' + this.instance + 'x' + subkey + '" class="tt1" align="center"><div' + style + title + '>' + info[5] + '</div></td><td id="' + this.instance + subkey + '" class="tt2" title="' + t_arrow + '">' + arrow + '</td><td class="tt3" title="' + ddtip + '">' + departs + '</td><td class="tt4">' + info[6] + '</td>' + (this.editmode ? '<td class="ttc"><input type="checkbox" name="h_' + id + ')" id="' + this.instance + '_h_' + id + '" onclick="' + this.instance + '.hide(\'' + id + '\', !this.checked)" value="1"' + (!this.excludes[id] ? ' checked' : '') + ' title="' + t.show + '" /></td>' : '') + '</tr>\n';
                this.hide_boxes[id] = this.instance + '_h_' + id;
            }
        }
        ret.sort();
        lng = ret.length <= 16 ? 1 : this.tt_long;
        for (var r = 0; r < ret.length; r++) {
            var tt = ret[r].split('|');
            tmp = seen[tt[1]] ? seen[tt[1]] : 0;
            if ((tmp == 0 || tt[2] == "0") && tmp < 2 && !(tt[0] >= 500000 && (tmp > 0 || tt[2] != "0"))) {
                seen[tt[1]] = tmp + 1;
                if (tt[0] >= 500000 && !moreshown++ && this.laterlines)
                    html[html.length] = '<tr><td id="' + this.instance + 'x5" colspan="4" class="ttmore">' + (lng ? t[morelabel] : '<a href="#" onclick="return ' + this.instance + '.moreln()">' + t[morelabel] + '</a>') + '</td></tr>';
                if (!moreshown || lng)
                    html[html.length] = tt[3];
            }
        }
        html.sort();
        var down = '<span class="ttdown">&#9660;</span>',
            invis = '<span class="ttdown" style="visibility:hidden">&#9660;</span>';
        return html.length ? (!innerhtml ? '<div class="ttshort" id="tt' + this.id + 'body">' : '') + '<table class="ovt"><colgroup><col class="tt1"><col class="tt2"><col class="tt3"><col class="tt4">' + (this.editmode ? '<col class="ttc">' : '') + '</colgroup><tr><th align="right" colspan="2"><a href="#" onclick="return ' + this.instance + '.sort(0)" title="' + t.sortby + '">' + t.line + '</a>' + (this.sorting == 0 ? down : invis) + '</th><th><a href="#" onclick="return ' + this.instance + '.sort(1)" title="' + t.sortby + '">' + t.depart + '</a>' + (this.sorting == 1 ? down : invis) + '</th><th class="tt4"><a href="#" onclick="return ' + this.instance + '.sort(2)" title="' + t.sortby + '">' + t.dir + '</a>' + (this.sorting == 2 ? down : invis) + '</th>' + (this.editmode ? '<th class="ttc"><input type="checkbox" name="' + this.instance + '_select_all" onclick="' + this.instance + '.select_all(this.checked)" value="1"' + (!this.have_excludes() ? ' checked' : '') + ' /></th>' : '') + '</tr>' + html.join("") + '</table>' + (!innerhtml ? '</div>' : '') : '';
    },
    get_form: function () {
        var t = this.env.text;
        var form = '<span id="oevtttabs' + this.id + '" class="tabnrm">' + (this.surroundingform ? '' : '<form action="' + this.timetableurl + '" method="get">') +
            '<table><tr><td class="tabfirst">' + t.timetable + '</td><td id="oevtttab' + this.id + '1" class="tabon"><a href="#" class="tabhide" onclick="return ' + this.instance + '.tabtoggle(1)">' + t.tohere + '</a><span class="tabshow">' + t.tohere + '</span></td><td id="oevtttab' + this.id + '2" class="taboff"><a href="#" class="tabshow" class="on" onclick="return ' + this.instance + '.tabtoggle(0)">' + t.fromhere + '</a><span class="tabhide">' + t.fromhere + '</span></td></tr></table>' +
            '<table class="tabbot"><tr class="tabhide"><td><span>' + t.from + '</span></td><td colspan="2">' + this.here + '<td></tr><tr><td style="width:1%"><span class="tabshow">' + t.from + '</span><span class="tabhide">' + t.to + '</span></td><td style="width:98%"><input type="text" name="there" id="tt' + this.id + 'there" value="' + this.home + '" class="tabinput" onfocus="this.select()" onkeypress="return ' + this.instance + '.keypress(event)" /></td><td style="width:1%"><input type="hidden" id="oevtttohere' + this.id + '" name="tohere" value="1"><input type="hidden" name="here" value="' + this.here + '"><input type="submit" onclick="return ' + this.instance + '.submit();" name="start" class="ttsub" value="&nbsp;&#x00bb;&nbsp;"></tr>' +
            '<tr class="tabshow"><td><span>' + t.to + '</span></td><td colspan="2">' + this.here + '</td></tr></table>' + (this.surroundingform ? '' : '</form>') + '</span>';
        return form;
    },
    hide: function (id, h) {
        this.excludes[id] = h;
    },
    select_all: function (a) {
        for (var id in this.hide_boxes) {
            it_element(this.hide_boxes[id]).checked = a;
            this.hide(id, !a);
        }
    },
    have_excludes: function () {
        for (var n in this.excludes)
            if (n && this.excludes[n])
                return true;
        return false;
    },
    keypress: function (ev) {
        var key = ev.keyCode;
        if (key == 13 && this.surroundingform)
            this.submit();
        return true;
    },
    submit: function () {
        if (this.surroundingform) {
            if (this.surroundingform.home)
                this.surroundingform.home.value = it_element('tt' + this.id + 'there').value;
            this.surroundingform.action = this.timetableurl;
        }
        return true;
    },
    sort: function (sorting) {
        var changed = (sorting != this.sorting);
        this.env['tt_sort'] = sorting;
        this.sorting = sorting;
        if (changed) {
            this.saveconfig('sort', sorting);
            if (this.container)
                it_element(this.container).innerHTML = this.get_timetable();
            else
                it_element(this.body).innerHTML = this.get_timetable(true);
        }
        return false;
    },
    moreln: function () {
        this.tt_long = !this.tt_long;
        if (this.container)
            it_element(this.container).innerHTML = this.get_timetable();
        else
            it_element(this.body).innerHTML = this.get_timetable(true);
        return false;
    },
    tabtoggle: function (tohere) {
        it_element('oevtttab' + this.id + '2').className = tohere ? "taboff" : "tabon";
        it_element('oevtttab' + this.id + '1').className = tohere ? "tabon" : "taboff";
        it_element('oevtttabs' + this.id).className = tohere ? "tabnrm" : "tabrev";
        it_element('oevtttohere' + this.id).value = tohere;
        return false;
    },
    refresh: function (p) {
        var c;
        if ((c = it_element(this.container))) {
            c.innerHTML = this.get_timetable();
            if (p && p.continuous == false && !this.editmode)
                this.timer = new it_timer({object: this, method: "refresh", timeout: 60000, continuous: true});
        } else if (this.timer)
            this.timer.stop();
    },
    start_timer: function () {
        this.timer = new it_timer({
            object: this,
            method: "refresh",
            timeout: (61 - new Date().getSeconds()) * 1000,
            continuous: false
        });
    },
    save: function (form, id) {
        if (form.stop.value != this.here)
            return true;
        this.display = form.disp.selectedIndex;
        this.timeoffset = isNaN(form.offset.value) ? 0 : Math.floor(parseFloat(form.offset.value));
        ca_toggle(id);
        this.refresh();
        this.saveconfig();
        return false;
    },
    saveconfig: function (key, value) {
        if (this.saveconfig_wrapper)
            this.saveconfig_wrapper(this, key, value);
    }
};

function ca_save_oev_config(obj) {
    var ex = [];
    for (var n in this.excludes)
        if (this.excludes[n])
            ex[ex.length] = n;
    var img = new Image();
    img.src = '/save.gif?_MODCONFIG=' + obj.env.id + '&sort=' + obj.sorting + '&disp=' + obj.display + '&offset=' + obj.timeoffset + '&excls=' + ex.join(':') + '&t=' + new Date().getTime();
}

function ca_O_toggle(id, mode) {
    var tt;
    if ((tt = window['tt' + id])) {
        if (mode && tt.timer)
            tt.timer.stop();
        tt.editmode = mode;
        tt.refresh();
        if (!mode) {
            tt.saveconfig('excls');
            tt.start_timer();
        }
    }
}

function ca_O_remove(id) {
    var tt = window['tt' + id];
    if (tt && tt.timer)
        tt.timer.stop();
}

SearchChMap.prototype.env = {
    zoommax: 6,
    zoomlevels: [512, 128, 32, 8, 2, 1, "0.5"],
    zoomparams: [1, 4, 16, 64, 256, 512, 1024],
    unitlevels: [50000, 10000, 3000, 1000, 200, 100, 50],
    rect: ["511.73020527859", "127.97946461313", "32.00073354117", 8, 2, 1, "0.5"],
    language: "de",
    layer_src: {
        high: ["bg", "fg", "bg,fg,copy"],
        low: ["sym", "fg", "sym,fg,copy"]
    },
    layer_format: {
        high: [".jpg", ".gif"],
        low: [".jpg", ".gif"]
    },
    base_corr: {
        bg: {
            x: [6, 9, 5, 3, 12, 8, 0],
            y: [1, 4, 0, 14, 8, 0, 0]
        },
        sym: {
            x: [6, 9, 5, 3, 12, 8, 0],
            y: [1, 4, 0, 14, 8, 0, 0]
        }
    },
    map_server: "http://map.search.ch",
    tile_server: "http://map.search.ch/chmap.de",
    num_tiles: 6,
    tot_tiles: 72,
    tt_home: "",
    tt_sort: 0,
    timetableurl: "http://map.search.ch/timetable.html",
    sbburl: "http://fahrplan.sbb.ch/bin/bhftafel.exe/dn",
    apikey: "",
    n: 0,
    maxtilesize: 640,
    transform: [["511.73020527859", 662000, "-511.57407407407", 190000], ["127.97946461313", 662000, "-127.96757382745", 190000], ["32.00073354117", 662000, "-32.001158412974", 190000], [8, 662000, -8, 190000], [2, 662000, -2, 190000], [1, 662000, -1, 190000], ["0.5", 662000, "-0.5", 190000]],
    poilist: {
        verkehr: {
            name: "Verkehr",
            subtypes: {
                bergbahn: "Bergbahn",
                parkhaus: "Parkhaus",
                haltestelle: "Tram/Bus",
                zug: "Zug",
                viasuisse: "Verkehrsinfo"
            }
        },
        gastro: {
            name: "Gastronomie",
            subtypes: {
                bar: "Bar",
                cafe: "Caf\u00e9",
                hotel: "Hotel",
                restaurant: "Restaurant"
            }
        },
        kultur: {
            name: "Kultur/Freizeit",
            subtypes: {
                kino: "Kino",
                museum: "Museum",
                theater: "Theater",
                tour: "Touren",
                feuerstelle: "Feuerstelle",
                spielplatz: "Spielplatz",
                bad: "Badeanstalt"
            }
        },
        gebaeude: {
            name: "\u00d6ffentl.&nbsp;Geb\u00e4ude",
            subtypes: {
                kirche: "Kirche",
                polizei: "Polizei",
                schule: "Schule, Uni",
                spital: "Spital",
                verwaltung: "Verwaltung"
            }
        },
        service: {
            name: "Shopping/Service",
            subtypes: {
                apotheke: "Apotheke",
                geldautomat: "Geldautomat",
                post: "Post",
                shop: "Shop",
                tankstelle: "Tankstelle"
            }
        },
        geo: {
            name: "Geo/Wetter",
            subtypes: {
                berg: "Berge",
                pass: "P\u00e4sse",
                wasserfall: "Wasserf\u00e4lle",
                webcam: "Webcam",
                meteoradar: "Regenradar",
                wikipedia: "Wikipedia"
            }
        },
        anzeigen: {
            name: "Anzeigen",
            subtypes: {
                maplink: "Lokalwerbung",
                mobility: "Mobility"
            }
        }
    },
    alltypes: ["business", "person", "bergbahn", "parkhaus", "haltestelle", "zug", "viasuisse", "bar", "cafe", "hotel", "restaurant", "kino", "museum", "theater", "tour", "feuerstelle", "spielplatz", "bad", "kirche", "polizei", "schule", "spital", "verwaltung", "apotheke", "geldautomat", "post", "shop", "tankstelle", "berg", "pass", "wasserfall", "webcam", "meteoradar", "wikipedia", "maplink", "mobility"],
    poicombine: {
        'business,person,bergbahn,parkhaus,haltestelle,zug,viasuisse,bar,cafe,hotel,restaurant,kino,museum,theater,tour,feuerstelle,spielplatz,bad,kirche,polizei,schule,spital,verwaltung,apotheke,geldautomat,post,shop,tankstelle,berg,pass,wasserfall,webcam,meteoradar,wikipedia,maplink,mobility': "all",
        'business,person': "tel",
        'bergbahn,parkhaus,haltestelle,zug,viasuisse': "verkehr",
        'bar,cafe,hotel,restaurant': "gastro",
        'kino,museum,theater,tour,feuerstelle,spielplatz,bad': "kultur",
        'kirche,polizei,schule,spital,verwaltung': "gebaeude",
        'apotheke,geldautomat,post,shop,tankstelle': "service",
        'berg,pass,wasserfall,webcam,meteoradar,wikipedia': "geo",
        'maplink,mobility': "anzeigen"
    },
    poi_defaults: ["", "", "", "", "bergbahn,parkhaus,haltestelle,zug,viasuisse,maplink,mobility", "bergbahn,parkhaus,haltestelle,zug,viasuisse,maplink,mobility", "business,person,bergbahn,parkhaus,haltestelle,zug,viasuisse,bar,cafe,hotel,restaurant,kino,museum,theater,tour,feuerstelle,spielplatz,bad,kirche,polizei,schule,spital,verwaltung,apotheke,geldautomat,post,shop,tankstelle,berg,pass,wasserfall,webcam,meteoradar,wikipedia,maplink,mobility"],
    poidir: [7, 7, 7, 17, 17, 17, 21],
    text: {
        business: "Organisation",
        person: "Privatperson",
        gondelbahn: "Gondelbahn",
        luftseilbahn: "Luftseilbahn",
        schienenbahn: "Bergbahn",
        sesselbahn: "Sesselbahn",
        skilift: "Skilift",
        parkhaus: "Parkhaus",
        parkhaus_g: "Parkhaus (frei)",
        parkhaus_o: "Parkhaus (fast voll)",
        parkhaus_r: "Parkhaus (besetzt)",
        haltestelle: "Tram-/Bushaltestelle",
        tram: "Tramhaltestelle",
        bus: "Bushaltestelle",
        schiff: "Schiffsstation",
        zug: "Bahnhof",
        vinfo: "Verkehrsmeldung",
        gesperrt: "Gesperrt",
        stau: "Staumeldung",
        baustelle: "Baustelle",
        autoverlad_g: "Autoverlad (offen)",
        autoverlad_r: "Autoverlad (geschlossen)",
        tunnel_g: "Tunnelzufahrt (offen)",
        tunnel_r: "Tunnelzufahrt (gesperrt)",
        vpass_g: "Pass\u00fcbergang (offen)",
        vpass_r: "Pass\u00fcbergang (gesperrt)",
        bar: "Bar",
        cafe: "Caf\u00e9",
        hotel: "Hotel",
        restaurant: "Restaurant",
        kino: "Kino",
        museum: "Museum",
        theater: "Theater",
        tour_velo: "Velotour",
        tour_wanderung: "Wanderung",
        tour_mountainbike: "Mountainbiketour",
        tour_ski: "Skitour",
        tour_winterwanderung: "Winterwanderung",
        tour_alpin: "Alpintour",
        tour_nordicwalking: "Nordicwalking",
        tour_jogging: "Joggingtour",
        tour_inlineskating: "Inlineskating",
        tour_ort: "Ortstour",
        feuerstelle: "Feuerstelle",
        spielplatz: "Spielplatz",
        freibad: "Badeanstalt",
        kirche: "Kirche",
        polizei: "Polizei",
        schule: "Schule, Uni",
        spital: "Spital",
        verwaltung: "Verwaltung",
        apotheke: "Apotheke",
        geldautomat: "Geldautomat",
        post: "Post",
        shop: "Shop",
        tankstelle: "Tankstelle",
        berg: "Berge",
        pass: "P\u00e4sse",
        fusspass: "Pass\u00fcbergang",
        wasserfall: "Wasserf\u00e4lle",
        webcam: "Webcam",
        meteoradar: "Regenradar",
        wikipedia: "Wikipedia",
        maplink: "Lokalwerbung",
        mobility: "Mobility",
        temp: "Wassertemperatur",
        tut: "Tutanchamun - sein Grab und die Sch\u00e4tze",
        track_run: "Gigathlon Verlosung",
        line: "Linie",
        depart: "Abfahrten",
        dir: "Richtung",
        arrow: "Richtung des n\u00e4chsten Halts",
        type_str: "S-Bahn",
        type_tra: "Tram",
        type_n_str: "Nacht-S-Bahn",
        type_bus: "Bus",
        type_n_bus: "Nachtbus",
        type_post: "Postauto",
        timetable: "SBB-Fahrplan",
        tohere: "hierher",
        fromhere: "ab hier",
        to: "Nach:",
        from: "Von:",
        laterlines: "sp\u00e4tere",
        longdist: "sp\u00e4tere/Fernverkehr",
        sbblnk: "SBB-Abfahrtstabelle",
        sortby: "sortieren",
        nottoday: "verkehrt heute nicht (mehr)",
        invalidkey: "Der API-Schl\u00fcssel ist ung\u00fcltig oder gesperrt",
        zoomout: "Wegzoomen",
        routestart: "Start",
        routestopover: "Zwischenstopp",
        routedestination: "Ziel"
    },
    copyright: "<a id=\"%scopyrightlink\" target=\"_top\" href=\"http://map.search.ch/terms.html\"><img src=\"http://map.search.ch/images/copyright.gif\" id=\"%scopyright\" class=\"copyright\" border=\"0\" alt=\"Copyright\" /><\/a>",
    zoomtempl: "<table><tr><td class=\"magnifyer\"><a href=\"#\" id=\"%sazoomin\"><img src=\"http://map.search.ch/images/zoom_in.gif\" alt=\"Heranzoomen\" title=\"Heranzoomen\" id=\"%szoomin\" /><\/a><\/td>\n<td id=\"%szoomindex6\" class=\"zoff\"><a href=\"#\" id=\"%sazoomindex6\"><img src=\"http://map.search.ch/images/0.gif\" width=\"6\" class=\"zlimg\" alt=\"\" /><\/a><\/td>\n<td id=\"%szoomindex5\" class=\"zoff\"><a href=\"#\" id=\"%sazoomindex5\"><img src=\"http://map.search.ch/images/0.gif\" width=\"5\" class=\"zlimg\" alt=\"\" /><\/a><\/td>\n<td id=\"%szoomindex4\" class=\"zoff\"><a href=\"#\" id=\"%sazoomindex4\"><img src=\"http://map.search.ch/images/0.gif\" width=\"4\" class=\"zlimg\" alt=\"\" /><\/a><\/td>\n<td id=\"%szoomindex3\" class=\"zoff\"><a href=\"#\" id=\"%sazoomindex3\"><img src=\"http://map.search.ch/images/0.gif\" width=\"3\" class=\"zlimg\" alt=\"\" /><\/a><\/td>\n<td id=\"%szoomindex2\" class=\"zoff\"><a href=\"#\" id=\"%sazoomindex2\"><img src=\"http://map.search.ch/images/0.gif\" width=\"2\" class=\"zlimg\" alt=\"\" /><\/a><\/td>\n<td id=\"%szoomindex1\" class=\"zoff\"><a href=\"#\" id=\"%sazoomindex1\"><img src=\"http://map.search.ch/images/0.gif\" width=\"1\" class=\"zlimg\" alt=\"\" /><\/a><\/td>\n<td id=\"%szoomindex0\" class=\"zoff\"><a href=\"#\" id=\"%sazoomindex0\"><img src=\"http://map.search.ch/images/0.gif\" width=\"0\" class=\"zlimg\" alt=\"\" /><\/a><\/td>\n<td class=\"magnifyer\"><a id=\"%sazoomout\" href=\"#\"><img src=\"http://map.search.ch/images/zoom_out.gif\" alt=\"Wegzoomen\" title=\"Wegzoomen\" id=\"%szoomout\" /><\/a><\/td>\n<\/tr>\n<\/table>\n",
    typetempl: "<a href=\"#\" id=\"%stosym\" class=\"bandwlink_active\">Karte<\/a> | <a href=\"#\" id=\"%stofoto\" class=\"bandwlink_active\">Luftbild<\/a>",
    unittempl: "<div class=\"ruler\" id=\"%sunitruler\"><div class=\"ruler_text\" id=\"%sm2p\">&nbsp;<\/div>\n<img id=\"%srulerimg\" src=\"http://map.search.ch/images/0.gif\" alt=\"\" width=\"100\" class=\"ruler_img\" /><\/div>\n",
    pantempl: "<img src=\"http://map.search.ch/images/pan.gif\" width=\"40\" height=\"40\" alt=\"\" id=\"%spanimg\" />"
};
