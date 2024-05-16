import './App.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Home from './Component/Home';
import Header from './Component/Header';
import Footer from './Component/Footer';
import AddImage from './Component/AddImage';

const App = () => {
  return (
    <div className="App">
      <Router>
        <Header />
        <Routes>
          <Route path="/" element={<Home />} />
          <Route exact path="/add-image" element={<AddImage />} />
        </Routes>
        <Footer />
      </Router>
    </div>
  );
};

export default App;
