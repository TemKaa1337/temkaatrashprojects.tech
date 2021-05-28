# temkaatrashprojects.tech
Actually, this is a repo for my website, where my main projects are located with demos.
Sometimes (always) that are trash projects, that dont help community, but that's it.
I will always add my new projects to this website, so it is always under developing...

To install project on your machine clone this project.
After cloning project to your machine type
```
cd temkaatrashprojects.tech
mv .env.example .env
php artisan key:generate
```
After that configure .env by changing your database credentials and set GITHUB_URL variable to your url.
Example - https://api.github.com/users/{username}/repos
Then change url in `components\content\Content.js` to your website url (if you are using `php artisan serve` comamnd then set it to `http://127.0.0.1:8000`).
Then type
```
php artisan migrate:refresh
```
Finally
```
php artisan serve
```
and check the result!
