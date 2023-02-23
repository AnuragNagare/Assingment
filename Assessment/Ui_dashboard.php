//JavaSscript code to create a UI dashboard for AWS S3 bucket maintenance using UI components with React and AWS Amplify:



import React, { useState, useEffect } from 'react';
import { AmplifyAuthenticator, AmplifySignOut } from '@aws-amplify/ui-react';
import { AuthState, onAuthUIStateChange } from '@aws-amplify/ui-components';
import { S3 } from 'aws-sdk';
import { Button, Card, Input, Table } from 'antd';
import 'antd/dist/antd.css';

const { Column } = Table;

const App = () => {
  const [authState, setAuthState] = useState();
  const [user, setUser] = useState();
  const [buckets, setBuckets] = useState([]);
  const [objects, setObjects] = useState([]);
  const [bucketName, setBucketName] = useState('');
  const [objectKey, setObjectKey] = useState('');
  const [file, setFile] = useState(null);

  useEffect(() => {
    onAuthUIStateChange((nextAuthState, authData) => {
      setAuthState(nextAuthState);
      setUser(authData);
    });
  }, []);

  const listBuckets = async () => {
    const s3 = new S3({ region: 'us-west-2' });
    const data = await s3.listBuckets().promise();
    setBuckets(data.Buckets);
  };

  const listObjects = async (bucketName) => {
    const s3 = new S3({ region: 'us-west-2' });
    const data = await s3.listObjects({ Bucket: bucketName }).promise();
    setObjects(data.Contents);
  };

  const createBucket = async () => {
    const s3 = new S3({ region: 'us-west-2' });
    await s3.createBucket({ Bucket: bucketName }).promise();
    listBuckets();
  };

  const deleteBucket = async (bucketName) => {
    const s3 = new S3({ region: 'us-west-2' });
    await s3.deleteBucket({ Bucket: bucketName }).promise();
    listBuckets();
  };

  const uploadObject = async () => {
    const s3 = new S3({ region: 'us-west-2' });
    await s3.upload({ Bucket: bucketName, Key: objectKey, Body: file }).promise();
    listObjects(bucketName);
  };

  const deleteObject = async (objectKey) => {
    const s3 = new S3({ region: 'us-west-2' });
    await s3.deleteObject({ Bucket: bucketName, Key: objectKey }).promise();
    listObjects(bucketName);
  };

  return authState === AuthState.SignedIn && user ? (
    <div>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', padding: '1rem' }}>
        <h1>S3 Bucket Maintenance Dashboard</h1>
        <AmplifySignOut />
      </div>
      <div style={{ display: 'flex', gap: '1rem', padding: '1rem' }}>
        <Card title="Buckets" style={{ flex: 1 }}>
          <Table dataSource={buckets} rowKey="Name">
            <Column title="Bucket Name" dataIndex="Name" />
            <Column
              title="Action"
              render={(text, record) => (
                <Button type="danger" onClick={() => deleteBucket(record.Name)}>
                  Delete
                </Button>
              )}
            />
          </Table>
          <Input placeholder="Enter bucket name" value={bucketName