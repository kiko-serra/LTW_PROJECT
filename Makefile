

DBFOLDER = database
DB = $(DBFOLDER)/uber.db

DBCREATE = $(DBFOLDER)/database.sql
DBPOP = $(DBFOLDER)/populate.sql

PORT = 9000

all: server 


server: db
	@php -S localhost:$(PORT)


db: $(DBFOLDER)/*.sql
	sqlite3 $(DB) < $(DBCREATE)
	sqlite3 $(DB) <$(DBPOP)


