<h2 align="center">Emoji Sentiment Analyzer</h2>
Overview
The Emoji Sentiment Analyzer is a Laravel-based application designed to analyze and interpret the sentiment of text containing emojis. By leveraging advanced algorithms and real-time updates, this tool provides insightful analysis of user-generated content, helping to understand the emotional context conveyed through emojis.

Features
Emoji Sentiment Analysis: Detects and interprets the sentiment of text with emojis, classifying it as positive, negative, or neutral.
Real-time Updates: Utilizes Ably to deliver real-time sentiment analysis results to the frontend.
Queue Processing: Handles large volumes of data efficiently using Laravel's queue system.
User-Friendly Interface: Built with Livewire and Vite to provide a responsive and interactive user experience.
Scalable Architecture: Designed to scale with your application's needs and handle increasing amounts of data seamlessly.
Setup and Installation
Follow these steps to set up and run the Emoji Sentiment Analyzer on your local environment:

Prerequisites
PHP 8.0 or higher
Composer
Node.js and npm
Laravel 10.x or higher
Installation
Clone the Repository

git clone https://github.com/yourusername/emoji-sentiment-analyzer.git
cd emoji-sentiment-analyzer
Install PHP Dependencies

<code>
composer install
</code>

Set Up Environment File

Copy the .env.example file to a new .env file:

cp .env.example .env
Configure your environment variables in the .env file, including database settings, Ably credentials, and any other required configurations.

Generate Application Key

php artisan key:generate
Run Migrations

php artisan migrate
Install Node.js Dependencies

npm install
Build Assets

npm run dev
Start the Laravel Development Server

run reverb server
php artisan reverb:start

php artisan serve
