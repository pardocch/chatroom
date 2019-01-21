// Chat.js

import React, { Component } from 'react'
import { Link } from 'react-router-dom'
import axios from 'axios'

class Chat extends Component
{
    constructor(props) {
        super(props)
        this.state = {
            repos: [],
            data: '',
            isClicked: false
        }
        this.returnContent = this.returnContent.bind(this, '');
    }

    componentWillMount() {
        const {room} = this.props;
        this.setState({ repos: room });
    }

    componentDidMount() {
        if (this.state.repos.length !== 0) {
            if (this.state.isClicked === false) {
                this.getRooms(`http://${window.location.host}/room/${this.state.repos.room}`)
            }
        }
    }

    componentWillReceiveProps(next) {
        this.setState({
            repos: next.room,
            isClicked: false
        })
        this.getRooms(`http://${window.location.host}/room/${next.room}`)
    }

    async getRooms(url) {
        await axios.get(url).then((response) => { this.setState({ data: response.data, isClicked: true }) })
        
        if (this.props.isClicked) this.returnContent();
    }

    returnContent() {
        this.props.switchRoom(this.state.data);
    }

    render() {
        return(
            null
        )
    }
}

export default Chat;