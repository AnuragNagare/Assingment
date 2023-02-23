const AWS = require('aws-sdk');
const path = require('path');

AWS.config.update({
  accessKeyId: 'your-access-key-id',
  secretAccessKey: 'your-secret-access-key',
  region: 'your-region'
});

const s3 = new AWS.S3();
const bucketName = 'your-bucket-name';
const folderName = 'your-folder-name/';

const params = {
  Bucket: bucketName,
  Key: folderName
};

s3.putObject(params, function(err, data) {
  if (err) {
    console.log('Error:', err);
  } else {
    console.log('Folder created in bucket');
  }
});

/*
This code uses the AWS SDK for JavaScript to connect to an S3 bucket and create a folder. The Bucket parameter is set to the name of the bucket that you want to create the folder in. The Key parameter is set to the name of the folder.

The putObject function takes a callback function that will be called with the results of the operation. If there is an error, the err parameter will be set. If there are no errors, the data parameter will contain information about the uploaded file.*/


const AWS = require('aws-sdk');
const path = require('path');

AWS.config.update({
  accessKeyId: 'your-access-key-id',
  secretAccessKey: 'your-secret-access-key',
  region: 'your-region'
});

const s3 = new AWS.S3();
const bucketName = 'your-bucket-name';
const folderName = 'your-folder-name/';

const params = {
  Bucket: bucketName,
  Prefix: folderName
};

s3.listObjects(params, function(err, data) {
  if (err) {
    console.log('Error:', err);
  } else {
    const objects = data.Contents.map(function(object) {
      return { Key: object.Key };
    });
    const deleteParams = {
      Bucket: bucketName,
      Delete: {
        Objects: objects
      }
    };
    s3.deleteObjects(deleteParams, function(err, data) {
      if (err) {
        console.log('Error:', err);
      } else {
        console.log('Folder deleted from bucket');
      }
    });
  }
});