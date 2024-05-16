import { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

const AddImage = () => {
  const navigate = useNavigate();
  const [uploaderName, setUploaderName] = useState('');
  const [uploaderEmail, setUploaderEmail] = useState('');
  const [image, setImage] = useState('');
  const [message, setMessage] = useState('');

  const uploadImage = async () => {
    const formData = new FormData();
    formData.append('uploaderName', uploaderName);
    formData.append('uploaderEmail', uploaderEmail);
    formData.append('image', image);
    try {
      const response = await axios.post(
        'http://127.0.0.1:8080/api/images',
        formData,
        {
          headers: { 'Content-Type': 'multipart/form-data' },
        }
      );

      if (response.data.message) {
        setMessage(response.data.message);
      }

      setTimeout(() => {
        navigate('/');
      }, 2000);
    } catch (error) {
      if (error.response.data.errors) {
        for (const [key, value] of Object.entries(error.response.data.errors)) {
          setMessage(value[0]);
        }
      } else {
        console.log(error);
      }
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    await uploadImage();
  };

  return (
    <div className="container">
      <div className="row">
        <div className="col-md-8 mt-4">
          <h5 className="mb-4">Add Image </h5>
          <p className="text-primary">{message}</p>
          <form onSubmit={handleSubmit}>
            <div className="mb-3 row">
              <label className="col-sm-3">Uploader name </label>
              <div className="col-sm-9">
                <input
                  type="text"
                  className="form-control"
                  onChange={(e) => setUploaderName(e.target.value)}
                  required
                />
              </div>
            </div>
            <div className="mb-3 row">
              <label className="col-sm-3">Uploader email</label>
              <div className="col-sm-9">
                <input
                  type="email"
                  className="form-control"
                  onChange={(e) => setUploaderEmail(e.target.value)}
                  required
                />
              </div>
            </div>
            <div className="mb-3 row">
              <label className="col-sm-3">Image</label>
              <div className="col-sm-9">
                <input
                  type="file"
                  className="form-control"
                  onChange={(e) => setImage(e.target.files[0])}
                  required
                />
              </div>
            </div>
            <div className="mb-3 row">
              <label className="col-sm-3"></label>
              <div className="col-sm-9">
                <button type="submit" className="btn btn-success">
                  Submit
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default AddImage;
