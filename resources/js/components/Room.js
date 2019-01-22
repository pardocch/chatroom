// Room.js

import React, {Component} from 'react';
import { Router, Route } from 'react-router';
import { Link } from 'react-router-dom';
// import axios from 'axios';

class Room extends Component {
	constructor(props) {
		super(props);
		this.state = {
			itemdata: '',
			content: '',
			data: {
				message: '',
				roomid: '',
				userid: '',
				type: 'connect',
			},
			scontent: [],
		}
		this.handleContent = this.handleContent.bind(this);
		this.send = this.send.bind(this);
	}

	componentDidMount(){
		this.getAllList();
		this.wsServer = 'ws://127.0.0.1:9501';
		this.websocket = new WebSocket(this.wsServer);
		this.websocket.onmessage = (evt) => {
			this.appendMessage(evt.data, 'other');
		}
	}

	getAllList() {
		fetch(`http://${window.location.host}/room`, {
			method: 'GET'
		})
		.then((response) => {
			//ok 代表狀態碼在範圍 200-299
			if (!response.ok) throw new Error(response.statusText)
			return response.json()
		  })
		  .then((itemList) => {
			//  載入資料，重新渲染
			 this.setState({
			   itemdata: itemList,
			 })
		  })
		  .catch((error) => {
			//這裡可以顯示一些訊息
			//console.error(error)
		  })
	}

	handleRoom(room) {
		this.props.handleRoom(room);
	}

	handleContent(event) {
		this.setState({
			content: event.target.value,
			data: {
				message: event.target.value,
				roomid: this.props.room,
				userid: '',
				type: 'message'
			}
		});
	}

	send() {
		this.inputContent.value = '';
		this.websocket.send( JSON.stringify(this.state.data) );
		this.appendMessage(this.state.data.message, 'self');
	}

	appendMessage(message, target) {
		let newcontent = this.state.scontent;
		newcontent.push({'target': target, 'message': message});
		this.setState({
			scontent: newcontent
		});
	}

	insertMessage() {
		let table = [];
		(this.state.scontent).forEach((obj, i) => {
			let element;
			switch (obj.target) {
				case 'self':
					element = React.createElement(
						'div',
						{className: 'chat-block', key: i},
						React.createElement(
							'div',
							{className: 'col-md-offset-6 col-md-6 mf'},
							React.createElement(
								'div',
								{className: 'mt'},
								obj.message
							)
						)
					)
					break;
				case 'other':
					element = React.createElement(
						'div',
						{className: 'chat-block', key: i},
						React.createElement(
							'div',
							{className: 'cf'},
							React.createElement(
								'div',
								{className: 'ct'},
								obj.message
							)
						)
					)
					break;
			}
			table.push(element);
		});
		return table;
	}

	render() {
		let itemdata = this.state.itemdata;
		return (
			<div className="row">
				<div className="col-md-2">
					{(typeof(itemdata) == 'object') ?
						itemdata.map((obj, i) => 
						<Link to={'/room/'+JSON.parse(obj).roomid} key={i} style={{color: 'white'}}>
						<div><span className="btn-room" onClick={ () => { this.handleRoom(JSON.parse(obj).roomid) }} rooms={JSON.parse(obj).roomid} key={JSON.parse(obj).roomid}>{JSON.parse(obj).roomname}</span></div>
						</Link>) : ''
					}
				</div>
				<div className="col-md-8 center-block">
					<div className="chat-contain-field">
						<div className="chat-contain-field-border">
							{ this.insertMessage() }
						</div>
					</div>
					<div className="chat-text-field">
						<textarea className="chat-text-box" cols="30" rows="3" ref={el => this.inputContent = el} onChange={this.handleContent}></textarea>
					</div>
					<div className="chat-toolbar-field">
						<button className="btn btn-primary sendbtn" onClick={ this.send }>send</button>
					</div>
				</div>
				<div className="col-md-2 right-block"></div>
			</div>
		)
	}
}
export default Room;