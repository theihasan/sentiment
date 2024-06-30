<h2 align="center">Emoji Sentiment Analyzer</h2>

<p><strong>Overview</strong><br>
The Emoji Sentiment Analyzer is a Laravel-based application designed to analyze and interpret the sentiment of text containing emojis. By leveraging advanced algorithms and real-time updates, this tool provides insightful analysis of user-generated content, helping to understand the emotional context conveyed through emojis.</p>

<p><strong>Features</strong></p>
<ul>
  <li><strong>Emoji Sentiment Analysis</strong>: Detects and interprets the sentiment of text with emojis, classifying it as positive, negative, or neutral.</li>
  <li><strong>Real-time Updates</strong>: Utilizes Ably to deliver real-time sentiment analysis results to the frontend.</li>
  <li><strong>Queue Processing</strong>: Handles large volumes of data efficiently using Laravel's queue system.</li>
  <li><strong>User-Friendly Interface</strong>: Built with Livewire and Vite to provide a responsive and interactive user experience.</li>
  <li><strong>Scalable Architecture</strong>: Designed to scale with your application's needs and handle increasing amounts of data seamlessly.</li>
</ul>

<p><strong>Setup and Installation</strong><br>
Follow these steps to set up and run the Emoji Sentiment Analyzer on your local environment:</p>

<p><strong>Prerequisites</strong></p>
<ul>
  <li>PHP 8.0 or higher</li>
  <li>Composer</li>
  <li>Node.js and npm</li>
  <li>Laravel 10.x or higher</li>
</ul>

<p><strong>Installation</strong></p>
<p><strong>Clone the Repository</strong><br>
<code>git clone <a href="https://github.com/theihasan/sentiment.git">https://github.com/theihasan/sentiment.git</a></code><br>
<code>cd emoji-sentiment-analyzer</code></p>

<p><strong>Install PHP Dependencies</strong></p>
<pre><code>composer install</code></pre>

<p><strong>Set Up Environment File</strong></p>
<p>Copy the <code>.env.example</code> file to a new <code>.env</code> file:</p>
<pre><code>cp .env.example .env</code></pre>
<p>Configure your environment variables in the <code>.env</code> file, including database settings, Ably credentials, and any other required configurations.</p>

<p><strong>Generate Application Key</strong></p>
<pre><code>php artisan key:generate</code></pre>

<p><strong>Run Migrations</strong></p>
<pre><code>php artisan migrate</code></pre>

<p><strong>Install Node.js Dependencies</strong></p>
<pre><code>npm install</code></pre>

<p><strong>Build Assets</strong></p>
<pre><code>npm run dev</code></pre>

<p><strong>Start the Laravel Development Server</strong></p>
<pre><code>php artisan serve</code></pre>
<pre><code>run reverb server
php artisan reverb:start
</code></pre>
