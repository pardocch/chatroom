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
		}
	}

	getAllList() {
		fetch('http://localhost:8727/room', {
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
	componentDidMount(){
		this.getAllList();
	};
	render() {
		let itemdatalen = Object.keys(this.state.itemdata).length;
		let itemdata = this.state.itemdata;
		// console.log(itemdata);
		return (
			  <div className="container">
				{(typeof(itemdata) == 'object') ?
					Object.keys(itemdata).map((obj, i) => 
					<Link to={'/rooms/'+i} key={obj} style={{color: 'white'}}>
					<button className="btn btn-primary btn-room" rooms={itemdata[obj]} key={obj}>{itemdata[obj]}</button>
					</Link>) : ''
				}
			  </div>
		)
	}
}
export default Room;