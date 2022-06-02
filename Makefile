

DBFOLDER = database
DB = $(DBFOLDER)/uber.db

DBCREATE = $(DBFOLDER)/database.sql
DBPOP = $(DBFOLDER)/populate.sql

PORT = 5500

all: server 


server:
	google-chrome http://localhost:5500/ &
	@php -S localhost:$(PORT)


db: $(DBFOLDER)/*.sql
	sqlite3 $(DB) < $(DBCREATE)


