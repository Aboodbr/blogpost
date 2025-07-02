# 📝 Blog Post Management (CRUD Application)

A simple blogging platform that allows users to **Create**, **Read**, **Update**, and **Delete** blog posts. This application was built using **Laravel** for the backend and **Bootstrap** for the frontend.

## 🚀 Features

- 🆕 Create new blog posts
- 📖 View a list of all blog posts
- ✏️ Edit existing posts
- ❌ Delete posts
- 🗃️ Store data in a MySQL database
- 💻 Clean UI using Bootstrap

## 🛠️ Technologies Used

- **Laravel** (PHP Framework)
- **PHP**
- **MySQL**
- **HTML5**
- **Bootstrap 5**

## 📸 Screenshots

> *You can add screenshots here showing key features like post list, create form, edit view, etc.*

## 🧑‍💻 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/blog-crud-app.git
   cd blog-crud-app
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Set up environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   - Open `.env` file
   - Set your database credentials:
     ```
     DB_DATABASE=your_db_name
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Start the local development server**
   ```bash
   php artisan serve
   ```

7. Open your browser and visit: `http://localhost:8000`

## 📂 Folder Structure

- `routes/web.php` – defines the application routes
- `resources/views/` – contains Blade view templates
- `app/Http/Controllers/` – contains the CRUD logic
- `database/migrations/` – contains table structure for blog posts

## 📌 Notes

- Authentication is **not** implemented in this basic version.
- You can extend the app with features like tags, comments, or user login.

## 📃 License

This project is licensed under the [MIT License](LICENSE).

---

> Built with ❤️ using Laravel & Bootstrap