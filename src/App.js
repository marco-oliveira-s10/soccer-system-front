import React, { } from 'react';

import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Events from './components/Events';
import Players from './components/Players';
import Locations from './components/Locations';
import NotFound from './components/NotFound';

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Events />} />
        <Route path="/players" element={<Players />} />
        <Route path="/locations" element={<Locations />} />
        <Route path="*" element={<NotFound />} />
      </Routes>
    </Router>
  );
}

export default App;
