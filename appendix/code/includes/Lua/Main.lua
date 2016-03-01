JSON = (loadfile "JSON.lua")() -- one-time load of the routines

local fr = assert( io.open( "identifier-query.json", "r" ) )

local raw_json_text = fr:read( "*all" )

local fw = io.open( "Identifier.lua", "w" )

local lua_value = JSON:decode( raw_json_text )
local result = "local table = {"

for key, value in pairs( lua_value ) do
  for k, v in pairs( value ) do
   local propertyId = string.gsub( v, "http://www.wikidata.org/entity/", "" )
    result = result .. '["' .. propertyId .. '"] = true' .. ', '
  end
end

result = result .. "} \n return table"
fw:write( result )

fw.close()
