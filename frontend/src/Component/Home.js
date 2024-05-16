import { useState, useEffect } from 'react';
import axios from 'axios';
import InfiniteScroll from 'react-infinite-scroll-component';
import TableItem from './TableItem';

const Home = () => {
  const [images, setImages] = useState([]);
  const [page, setPage] = useState(1);
  const [totalResults, setTotalResults] = useState(1);

  useEffect(() => {
    getImages();
  }, []);

  const getImages = async () => {
    try {
      const response = await axios.get(
        'http://127.0.0.1:8080/api/images?page' + page
      );

      setImages(response.data.images.data);
      setTotalResults(response.data.images.total);
    } catch (error) {
      console.error(error);
    }
  };

  const fetchMoreData = async () => {
    try {
      const response = await axios.get(
        `http://127.0.0.1:8080/api/images?page=${page + 1}`
      );
      setPage(page + 1);
      setImages([...images, ...response.data.images.data]);
      setTotalResults(response.data.images.total);
      if (images.length >= totalResults) {
        setPage(1);
      }
    } catch (error) {
      console.error(error);
    }
  };

  const deleteImage = async (id) => {
    try {
      await axios.delete('http://127.0.0.1:8080/api/images/' + id);
    } catch (error) {
      console.error(error);
    }
    if (images.length <= 10) {
      getImages();
    } else {
      setImages((prevItems) => prevItems.filter((item) => item.id !== id));
    }
  };

  return (
    <>
      <div className="main-content container container_overflow mb-5">
        <div className="row">
          <div className="col-12">
            <h5 className="mb-4">Image List</h5>
            <InfiniteScroll
              dataLength={images.length}
              next={fetchMoreData}
              hasMore={images.length !== totalResults}
              loader={images.length > totalResults ? '' : <h4>Loading...</h4>}
              scrollThreshold={1}
            >
              <div className="divTable blueTable">
                <div className="divTableHeading">
                  <div className="divTableRow">
                    <div className="divTableHead">No.</div>
                    <div className="divTableHead">Image</div>
                    <div className="divTableHead">Extension</div>
                    <div className="divTableHead">Size</div>
                    <div className="divTableHead">Resolution</div>
                    <div className="divTableHead">Uploader name</div>
                    <div className="divTableHead">Action</div>
                  </div>
                </div>
                <div className="divTableBody">
                  {images.map((imageItem, index) => (
                    <TableItem
                      imageItem={imageItem}
                      key={index}
                      index={index}
                      deleteImage={deleteImage}
                    />
                  ))}
                </div>
              </div>
            </InfiniteScroll>
          </div>
        </div>
      </div>
    </>
  );
};

export default Home;
