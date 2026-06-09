import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Home from './pages/Home'; 
import About from './pages/About';
import Contact from './pages/Contact';
import Props from './pages/Props';
import Events from './pages/Events';
import Lists from './pages/Lists'; 
import Forms from './pages/Forms'; 
import './App.css';

export default function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/about" element={<About />} />
        <Route path="/contact" element={<Contact />} />
        <Route path="/Props" element={<Props />} />
        <Route path="/Events" element={<Events />} />
        <Route path="/Lists" element={<Lists />} />
        <Route path="/Forms" element={<Forms />} />
      </Routes>
    </BrowserRouter>
  );
}
