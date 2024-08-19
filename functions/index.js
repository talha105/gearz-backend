const functions = require('firebase-functions');
const admin = require('firebase-admin');
const { exec } = require('child_process');

admin.initializeApp();

exports.app = functions.https.onRequest((req, res) => {
  exec('php artisan serve', (error, stdout, stderr) => {
    if (error) {
      console.error(`Error: ${error.message}`);
      return res.status(500).send('Error starting server');
    }

    res.send('Laravel app is running');
  });
});
