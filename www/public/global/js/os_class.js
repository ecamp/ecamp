/** eCampConfig

	<depend on="public/global/js/mootools-core-1.4.js" type="js" /> <depend on="public/global/js/mootools-more-1.4.js" type="js" />

**/

var HD = new Class(
{
	Extends: Hash,
	read: function( path )
	{
		var file = this;
		
		[path].flatten().each( function( f )
		{
			if( file.has( f ) )
			{	file = file.get( f );	}
			else
			{	file = null;	return false;	}
		});
		
		return file;
	},
	
	write: function( path, index, value )
	{
		var file = this;
		
		[path].flatten().each( function( f )
		{
			if( !file.has( f ) )
			{	file.include( f, new Hash() );	}
			
			file = file.get( f );
		});
		
		file.set( index, value );
		
		return file;
	},
	
	unlink: function( path, index )
	{
		var file = this.read( path );
		
		if( file && file.has( index ) )
		{
			file.erase( index );
			return true;
		}
		else
		{	return false;	}
	},
	
	iread: function( path, info )
	{
		var file = this.read( path );
		if( !file || $type( file ) != 'hash' ){	return null;	}
		
		if( !file.has( '$META' ) ){	file.include( '$META', new Hash() );	}
		file = file.get( '$META' );
		
		
		[info].flatten().each( function ( f )
		{
			if( file.has( f ) )
			{	file = file.get( f );	}
			else
			{	file = null; 	return false;	}
		});
		
		return file;
	},
	
	iwrite: function( path, info, index, value )
	{
		var file = this;
		
		[path].flatten().each( function( f )
		{
			if( !file.has( f ) )
			{	file.include( f, new Hash() );	}
			
			file = file.get( f );
		});
		
		if( !file.get( '$META' ) ){	file.include( '$META', new Hash() );	}
		file = file.get( '$META' );
		META = file;
		
		[info].flatten().each( function( f )
		{
			if( !file.has( f ) )
			{	file.include( f, new Hash() );	}
			
			file = file.get( f );
		});
		
		file.set( index, value );
		
		return META;
	}
});

var DB = new Class(
{
	Extends: Hash,
	
	insert: function()
	{
		if( arguments.length == 1 )
		{
			data	= arguments[0];
			
			if( $type( data ) == 'object' )	{	data = new Hash( data );	}
			if( $type( data ) != 'hash' )	{	return false;	}
			
			data.each( function( table, table_name )
			{	this.insert( table_name, table );	}.bind(this) );
		}
		
		if( arguments.length == 2 )
		{
			table	= arguments[0];
			data	= arguments[1];
			
			if( $type( data ) == 'object' )	{	data = new Hash( data );	}
			if( $type( data ) != 'hash' )	{	return false;	}
			
			data.each( function( row, row_id )
			{	this.insert( table, row_id, row );	}.bind(this) );
		}
		
		if( arguments.length == 3 )
		{
			table	= arguments[0];
			row		= arguments[1];
			data	= arguments[2];

			if( $type( data ) == 'object' )	{	data = new Hash( data );	}
			
			data.each( function( item, index )
			{	this.insert( table, row, index, item );	}.bind(this) );
		}

		if( arguments.length == 4 )
		{
			table	= arguments[0];
			row		= arguments[1];
			index 	= arguments[2];
			data	= arguments[3];
			
			if( $type( data ) == 'object' )	{	data = new Hash( data );	}
			
			$OS.$HD.write( [ '$DB', table, row ], index, data );
		}
		
		return this;
	},
	
	update: function()
	{	return this.insert.run( arguments, this );	},
	
	remove: function()
	{
		last = arguments.length - 1;
		
		file = arguments[ last ];
		path = [ '$DB' ];
		
		for( i = 0; i < last; i++ )
		{	path.include( arguments[ i ] );	}
		
		$OS.$HD.unlink( path, file );
	},
	
	s_insert: function( table, row_id, row )
	{
		// Only Row insert!!
		this.insert( table, row_id, row );
		
		// Fire Events!!
	},
	
	s_update: function( table, row, index, value )
	{
		// Only Cell update!!
		this.update( table, row, index, value );
		
		// Fire Events!!
	},
	
	s_remove: function( table, row )
	{
		// Only Row remove!!
		this.remove( table, row );
		
		//Fire Events!!
	},
	
	b_insert: function( table, row_id, row )
	{
		// Only Row insert!!
		this.insert( table, row_id, row );
		
		// Save on Server!!
	},
	
	b_update: function( table, row, index, value )
	{
		// Only Cell Update!!
		this.update( table, row, index, value );
		
		// Save on Server!!
	},
	
	b_remove: function( table, row )
	{
		// Only Row remove!!
		this.remove( table, row );
		
		//Save on Server!!
	}
});

$OS = new Hash(
{
	$HD: new HD(),
	$DB: new DB()
});