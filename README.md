# db-connection
Simple php code  of working with MySQL database

<strong>backend.php</strong>
Receive requests from Front end and by using Handle class parses input data, and push to specific method to proceed

<strong>handle.php</strong>
It contains Handle class that has all logic. Extended Db_connection that helps to connect to MySQL database

<strong>db_connection.php</strong>
Includes connection with DB. 
Change constants  DB_NAME, DB_USER, DB_PASSWORD, DB_HOST according your settings of DB.
Default Methods: 
- get_id: in order to get unique id (protected method). 
    Params: $table - name of table
- set_data: insert data to DB
    Params: $table - name of table, $titles - key of fields, $values - values of keys
- get_data: receive data from specidifc DB
    Params: $table - name of table,$what - key(s) of what you nedd, $condition - conditions
- update_data: update data in DB
  Params: $table - name of table, $set - keys and their values in string format, $condition - conditions
