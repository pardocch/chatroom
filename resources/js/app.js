// app.js

require('./bootstrap');
import React, { Component } from 'react';
import { render } from 'react-dom';
// import { Router, Route, browserHistory, IndexRoute } from 'react-router';
import { Route, BrowserRouter } from 'react-router-dom'


import Room from './components/Room';
import Header from './components/Header';
import Chat from './components/Chat';

const App = () => (
	<div>
	  <Header />
	  <Room />
	  <Route path="/rooms/:rooms" component={Chat}/>
	</div>
  )

export default App;

render((
	<BrowserRouter>
	  <App />
	</BrowserRouter>
  ), document.getElementById('example'));