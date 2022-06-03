

DBFOLDER = database
DB = $(DBFOLDER)/uber.db

DBCREATE = $(DBFOLDER)/database.sql
DBPOP = $(DBFOLDER)/populate.sql

PORT = 8000

all: server 


server:
	google-chrome http://0.0.0.0:8000/ &
	@php -S 0.0.0.0:$(PORT)


db: $(DBFOLDER)/*.sql
	sqlite3 $(DB) < $(DBCREATE)
	cd database/populateScript;\
	python3 populate.py





