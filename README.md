#### Installation Instructions.

1. Download or clone repository.
2. Run npm install.
3. Create a database and update the database name, password etc in the .env file
4. Run the database migrations - php artisan migrate
5. Run the code to populate the countries in the database - php artisan db:seed --class=CountrySeeder
6. Run php artisan serve and npm start dev
7. Navigate to the root of the site (in my case its: 127.0.0.1:8000/) - you should be presented with a login screen. From that screen there is a link to register a new account.
8. After registering you'll be redirecte to the admin panel.

#### Things that still need to be done.

Below is a list of things that need to be done that I didn't get time to complete. The circle at the beginning of a sentence denotes the points to give priority to:

1. The dashboard needs more - graph etc.
2. Incorporate tooltips for the dashboard to display the dates - only the first "x" amount displays and the rest must be in a tooltip.
3. The popup/toast on the calendar page displays behind the calendar after saving the countries for a given day - css issue.
4. * A random color is being generated for each country when the database is seeded but the colors can look similar - 5 think it's a better option to rather display country flags in the legend as well as in the calendar.
6. * Being able to change the calendar's year as well as localisation for the calendar - the javascript package being used (dayjs)  supports localisation.
7. * Incorporating tooltips when the user hovers over a specifc date.
8. * Determining how to show the assigned countries for the days that fall outside of the current month (the greyed out blocks). 

#### File locations.

1. Language file - /lang
2. Javascript - /resources/js
3. Conrollers - /app/Http/Controllers
4. Models - /app/Models
5. Middleware - /app/Http/Middleware

#### Screenshots

I have created a folder called "screenshots" located at the root which contains screenshots of each page.