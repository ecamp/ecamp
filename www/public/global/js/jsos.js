/** eCampConfig

	<depend on="public/global/js/mootools-core-1.4.js" type="js" /> <depend on="public/global/js/mootools-more-1.4.js" type="js" />

**/

var LIFOKeyHandler = new Class(
{
	buffer: [],
	
	initialize: function()
	{
		window.addEvent( 'keydown', this.KeyHandler.bind(this) );
	},
	
	addKeyHandler: function( handler, eventstop )
	{
		this.buffer.include( { 'eventstop': eventstop, 'handler': handler } );
		return this;
	},
	
	removeLastKeyHandler: function()
	{
		this.buffer.erase( this.buffer.getLast() );
		return this;
	},
	
	KeyHandler: function( event )
	{
		if( this.buffer.getLast() )
		{
			if( this.buffer.getLast().eventstop )
			{	( new Event( event ) ).stop();	}
			
			if( ! this.buffer.getLast().handler.run( event ) )
			{	this.removeLastKeyHandler();	}
		}
	}
});

var PostLoader = new Class(
{
	loadenJS: null,
	loadenCSS: null,
	
	initialize: function()
	{
		this.loadenJS = new Hash();
		this.loadenCSS = new Hash();
	},
	
	loadJS: function( src )
	{	this.loadenJS.include( src, new Asset.javascript( src ) );	},
	
	unloadJS: function( src )
	{
		if( this.loadenJS.hasChild( src ) )
		{
			this.loadenJS.get( src ).destroy();
			this.loadenJS.erase( src );
		}
	},

	loadCSS: function( src )
	{	this.loadenCSS.include( src, new Asset.css( src ) );	},
	
	unloadCSS: function( src )
	{
		if( this.loadenCSS.hasChild( src ) )
		{
			this.loadenCSS.get( src ).destroy();
			this.loadenCSS.erase( src );
		}
	}
});

$JSOS = 
{
	KeyHandler: new LIFOKeyHandler(),
	PostLoader: new PostLoader()
};