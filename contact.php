<?php
/*
 * Name: Yolanda Gunter
 * Assignment: Coding 05
 * Purpose: Templating & Making a 3+ Page Website
 * Notes: Learning then implementing Mustache to create templates.
 */

//this will load the mustache template library
require_once 'mustache/mustache/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();

//this will create a new mustache template engine
$mustache = new Mustache_Engine;

//these lines load your header, footer, and body template into strings
$header = file_get_contents('templates/header.html');
$body = file_get_contents('templates/contact.html');
$footer = file_get_contents('templates/footer.html');

/*
 * the following three lines of code set up your PAGE SPECIFIC variables
 * these will be different page to page. page specific data is loaded into
 * an associative array where the key is used by Mustache as a {{variable}}
 * and the value is inserted into the page (see the template examples).
 */

//this will be used to send the page title into the page
$header_data = ["pagetitle" => "Contact Page"];

//this is empty because there is no data to send to the body in this example
$body_data = [];

function redirect($url) {
    ob_start();
    header('Location: ' . $url);
    ob_end_flush();
    die();
}

function main() {
    //this first if statement tests to make sure we have a valid $_POST array
    if (!empty($_POST)) {
 
        /* Cleaning routines below will strip anything harmful or extraneous out 
         * out of the submitted $_POST variables. */
        $name = substr(strip_tags(trim($_POST['name'])),0,64);
        $subject = substr(strip_tags(trim($_POST['subject'])),0,64);
        $message = substr(strip_tags(trim($_POST['message'])),0,64);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : $email = "";
        
        /* Test cleaned variable here. If we find and empty variable , we stop
         * processing because that means someone tried to send us something malicious or 
         * or incorrect.*/
        if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
            
            /* This forms the corect email headers to send an email */
            $headers = "FROM: $email\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
            
            
            /* Now try to send the email. If it succeeds, we redirect to a 
             * success page. if not, we redirect to an error page. */
            if (mail('yolanda@yolandagunter.com', $subject, $name . '\n\n' . $message, $headers)) {
                redirect('templates/success.html');
            } else {
                /* The query string at the end of each error redirect is so we 
                 * can tell which error triggered. In this case it has no effect
                 * on the redirect because we ignore it up on redirect. In a real
                 * production application we can capture the query string and 
                 * tailor our error message to the type of error. */
                redirect('templates/error.html?error=1');
            }
        } else {
            redirect('templates/error.html?error=2');
        } 
    } else {
            redirect('templates/error.html?error=3');
        }
}

//this calls main - kicks off the script
main();

//this is being used to send a footer title and local time to the footer
$footer_data = [
    "localtime" => date('l jS \of F Y h:i:s A'),
    "footertitle" => "Success Page"];

/*
 * this combines the variables with the templates and creates a complete web page.
 * each page can now have the same header and footer style with different variables
 * such as page title. in this way we can use a sigle header and footer template
 * for all pages, and only worry about changing the body from page to page.
 */
echo $mustache->render($header, $header_data) . PHP_EOL;
echo $mustache->render($body, $body_data) . PHP_EOL;
echo $mustache->render($footer, $footer_data) . PHP_EOL;