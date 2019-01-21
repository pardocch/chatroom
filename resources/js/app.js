// app.js

require('./bootstrap');
import React, { Component } from 'react';
import ReactDOM, { render } from 'react-dom';
// import { Router, Route, browserHistory, IndexRoute } from 'react-router';
import { Route, BrowserRouter } from 'react-router-dom'


import Room from './components/Room';
import Header from './components/Header';
import Chat from './components/Chat';

class App extends Component {
	

	constructor(props) {
		super(props);
		this.state = {
			data: '',
			room: '',
			isClicked: false,
			count: 1,
		}
		this.switchRoom.bind();
		this.handleRoom.bind();
	}

	switchRoom(text) {
		this.setState({
			data: text,
		});
		if (this.state.isClicked) {
			this.setState({
				isClicked: false,
			});
		}
	}

	handleRoom(room) {
		this.setState({
			room: room,
			isClicked: true
		});
	}

	render() {
		return (
			<div>
				<Header />
				<Room content={this.state.data} room={this.state.room} handleRoom={ (room) => {this.handleRoom(room)} } />
				<Chat isClicked={this.state.isClicked} room={this.state.room} switchRoom={ (text) => {this.switchRoom(text)} } />
			</div>
			)
	}
}

ReactDOM.render(<BrowserRouter><App /></BrowserRouter>, document.getElementById('example'));