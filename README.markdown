# ThinkSpace Backend

This is the backend repository for the ThinkSpace Idea Collection. Follow the steps shown below to setup the project locally.



## Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone https://github.com/ewsd-g8/thinkspace-backend.git
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Create Environment File**
   Copy the `.env.example` file to create a `.env` file:
   ```bash
   cp .env.example .env
   ```

5. **Configure Environment File**
   Open the `.env` file and add the necessary database credentials.
   ```bash
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587 
   MAIL_USERNAME=
   MAIL_PASSWORD=
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=
   MAIL_FROM_NAME="ThinkSpace"
   FILESYSTEM_DISK=public
   QUEUE_CONNECTION=database

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=
   DB_USERNAME=
   DB_PASSWORD=
   ```

6. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

7. **Run Migrations and Seed Database**
   ```bash
   php artisan migrate:fresh --seed
   ```

8. **Create Passport Personal Access Client**
   ```bash
   php artisan passport:client --personal
   ```

9. **Link Storage Directory**
   ```bash
   php artisan storage:link
   ```

10. **Start the Development Server**
    ```bash
    php artisan serve
    ```

11. **Run the Queue Worker**
    ```bash
    php artisan queue:work --tries=3
    ```

## Notes
- Ensure your database is running and properly configured in the `.env` file.
- The queue worker must be running to process background email features.