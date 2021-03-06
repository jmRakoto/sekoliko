import { Router } from '@reach/router';
import React from 'react';
import ReactDOM from 'react-dom';
import Link from './components/shared/Link';
import { baseUrl } from './core/variables';

let Home = () => <div>Home</div>;
let Dash = () => <div>Dash</div>;

function App() {
  return (
    <div>
      <h1>Sekoliko</h1>
      <Link to="/">Home</Link> | <Link to="/dashboard">Dashboard</Link>
      <Router basepath={baseUrl}>
        <Home path="/" />
        <Dash path="/dashboard" />
      </Router>
    </div>
  );
}

ReactDOM.render(<App />, document.getElementById('root'));
