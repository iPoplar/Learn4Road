
/*
 * GET home page.
 */

exports.index = function(req, res){
  res.render('main', {
    title: 'My First Express App',
    description: 'This is my first Express app, so go easy on me'
  });
};

/*
 * GET about page.
 */

exports.about = function(req, res){
  res.render('main', {
    title: 'About',
    subtitle: 'All about my Express app',
    description: 'I built this app using Node and the Express framework'
  });
};

/*
 * GET contact page.
 */

exports.contact = function(req, res){
  res.render('contact', {
    title: 'Contact Us',
    description: 'Send us a message and we\'ll get back to you'
  });
};

/*
 * POST contact page.
 */

// validate required fields
function isFilled(field) { 
  return field !== undefined && field !== ''; 
}
  
// validate email address
var emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

function isValidEmail(email) {
  return emailRegex.test(email);
} 

exports.contactPostHandler = function(req, res) {
  var response = 'Thank you for contacting us, we will get back to you as soon as possible',
      required = [ 'name', 'email', 'message' ], 
      missing = [],
      success = false;
  
  // check required fields
  missing = required.filter(function(prop) {
    return !isFilled(req.body[prop]);
  });

  if ( missing.length ) {
    response = 'Please fill out all required fields (' + missing.join(', ') + ')';
  }
  
  // check email
  else if ( !isValidEmail( req.body.email ) ) {
    response = 'Please enter a valid email address';
  }

  else {
    success = true;
  }
    
  // build the template variables
  var templateVars = {
    description: response,
    success: success
  };

  // error output
  if ( !success ) {
    console.log( response );
    
    templateVars.title = 'Contact Us';
    templateVars.name = req.body.name;
    templateVars.email = req.body.email;
    templateVars.message = req.body.message;
    
    // render the template
    res.render('contact', templateVars);
  }
  
  // else success output
  else {    
    // connect to your smtp server
    var emailjs = require('emailjs');
    var server = emailjs.server.connect({
      user: 'username',
      password: 'password',
      host: 'smtp.gmail.com',
      ssl: true
    });
    
    // build the email body with a datestamp
    var emailBody = 'From: ' + req.body.name + ' <' + req.body.email + '>' +
     "\n";
    emailBody += 'Message: ' + req.body.message + "\n\n";
    emailBody += 'Sent automatically from Node server on ' + Date();
    
    // send the email to the server admin
    server.send({
      from:    'Node Server <no-reply@localhost>', 
      to:      'Server Admin <admin@localhost>',
      subject: 'Contact form submission',
      text: emailBody
    }, function(err, message) {
      console.log(err || message);
      
      // if smtp error
      if ( err ) {
        res.send('Sorry, there was an error sending your message, please try again later');
      }
      // otherwise show success message
      else {
        templateVars.title = 'Message sent successfully'
        
        // render the template
        res.render('contact', templateVars);
      }
    });
  }
};


