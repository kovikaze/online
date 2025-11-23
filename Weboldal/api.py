from flask import Flask
from flask import request
import json
# pip3 install mysql-connector-python
import mysql.connector

class mysqlc():
 def __init__( self ):
  self._cnx = mysql.connector.connect( user="api", password="12345678", database="electric", host="<ip>", auth_plugin='mysql_native_password' )

 def close( self ):
  self._cnx.close()

 def get( self, query, buffered = False ):
  self._cursor = self._cnx.cursor( buffered = buffered )
  self._cursor.execute( query )

 def getNextElement( self ):
  return next( self._cursor )

 def insert( self, query ):
  self._cursor = self._cnx.cursor()
  self._cursor.execute( query )
  self._cnx.commit()

 def getRowCount( self ):
  return self._cursor.rowcount

app = Flask( __name__ )

@app.route( "/" )
def getRoot():
 return "API"

@app.route( "/list" )
def getProducts():
 con = mysqlc()
 con.get( "select name, type, value, price from products", True )
 if con.getRowCount() > 0:
  data = []
  try:
   while True:
    values = con.getNextElement()
    data.append( {"name": values[0], "type": values[1], "value": values[2], "price": str( values[3] )} )
  except StopIteration as e:
   pass
  return json.dumps( {"response-msg":"OK", "response-code": "200", "data": data} )
 return json.dumps( {"response-msg": "no products in table", "response-code": "404"} );

@app.route( "/new/product", methods=["POST"] )
def newProduct():
 name = request.form["prod_name"]
 ptype = request.form["prod_type"]
 value = request.form["prod_value"]
 price = request.form["prod_price"]
 con = mysqlc()
 con.insert( "insert into products set name=\"" + name + "\", type=\"" + ptype + "\", value=\"" + value + "\", price=\"" + price + "\";" )
 con.close()
 return json.dumps( {"response-msg":"OK", "response-code": "200"} )

if __name__ == "__main__":
 app.run( debug = True, host = "0.0.0.0", port = 80 )
