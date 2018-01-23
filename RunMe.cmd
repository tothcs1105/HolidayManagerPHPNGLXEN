@echo off
set clear=-clr
set entity=-ent
set database=-initdb
set fixture=-dbfix

IF "%1"=="" (
    echo HELP - Commands:
    echo %0 %clear% = Clear cache
    echo %0 %entity% = Generate entities
    echo %0 %database% = Initialize database from entities
    echo %0 %fixture% = Apply fixtures to database
)

IF "%1"=="%clear%" (
	echo Clearing cache...

	php bin/console cache:clear && echo Cache cleared! || echo ERROR!!!
)

IF "%1"=="%entity%" (
    echo Generating entities...

    php bin/console doctrine:generate:entities AppBundle/Entity/User
    php bin/console doctrine:generate:entities AppBundle/Entity/Role
    php bin/console doctrine:generate:entities AppBundle/Entity/Holiday
    php bin/console doctrine:generate:entities AppBundle/Entity/AvailableHoliday
    php bin/console doctrine:generate:entities AppBundle/Entity/TakenHoliday
)

IF "%1"=="%database%" (
    echo Generating database...

    php bin/console doctrine:schema:drop --force --full-database
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:update --force
)

IF "%1"=="%fixture%" (
    echo Applying fixtures...

    php bin/console doctrine:fixtures:load --fixtures=src/AppBundle/DataFixture/ORM --no-interaction -vvv && echo Fixtures applied! || echo ERROR!!!
)