<h1>ChatBot</h1>
<p>Developed by <b>Daniel F. Rivera C.</b></p>
<hr>
<h2>Description</h2>
<p>This project consist on a single page app with a chatbot, that allows users to interact and perform some money transaction in an account.</p>
<hr>
<h2>Installation</h2>
<h3>Requirements</h3>
<p>This is a web app so it needs to be executed on an Apache server</p>
<p>In order to make the app work you'll need to ensure you have:</p>
<ul>
<li>Apache Server</li>
<li>PHP 7+</li>
<li>MySQL</li>
<li>Composer</li>
</ul>
<hr>
<h2>Database Config</h2>
<p>Once you have MySQL installed and can access through a client to the server, just need to create a database, it must be named jobsity_chatbot.</p>
<p>If you're working on mysql shell you could enter on SQL mode and execute the next commands:</p>
<code>create database jobsity_chatbot;</code><br/>
<code>use jobsity_chatbot;</code>
<p>Whe you have the database created, just need to import the file you'll find at <kbd>database/schema/jobsity_chatbot.sql</kbd>
<hr>
<h2>How to</h2>
<p>The entire app works based on session variables, so the interaction of each user is independent.
<h3>Login/Sigin</h3>
<p>In order to start interacting with the bot you need to create an account</p>
<p>All operations are made inside the chat box</p>
<p>The commands to login and signin are <kbd>login</kbd> and <kbd>signin</kbd></p>
<h3>Bot Tasks</h3>
<p>When you're logged, the chat bot can perform some action with your account</p>
<p><kbd>deposit</kbd> let you increase your amount of money</p>
<p><kbd>withdraw</kbd> let you decrease the amount of money just if it doesn't mean to reach negative values</p>
<p><kbd>balance</kbd> let you know your current amount of money</p>
<p><kbd>defaultcurrency</kbd> lets you change your default currency code. When you change it, your current amount of money is converted to that currency</p>
<p><kbd>convert</kbd> Lets you request conversion between different currency codes, just sending one input</p>
<p><kbd>logout</kbd> Lets you end your current session.</p>
<hr>
<h2>Inputs</h2>
<p>The chatbot isn't case "or space" sensitive, so even if you type <kbd>login</kbd>, <kbd>LOGIN</kbd> or <kbd>l o g i n</kbd> the chatbot will be able to identify your command.</p>
