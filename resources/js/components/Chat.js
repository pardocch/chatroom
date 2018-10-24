// Chat.js

import React, { Component } from 'react'
import { Link } from 'react-router-dom'
import axios from 'axios'

class Chat extends Component
{
    constructor() {
        super()
        this.state = {
            repos: [],
            data: '',
            isClicked: false
        }

    }

    componentWillMount() {
        const {rooms} = this.props.match.params
        this.setState({ repos: rooms })

    }

    componentDidMount() {
        if (this.state.repos.length !== 0) {
            if (this.state.isClicked === false) {
                this.getRooms(`http://localhost:8727/room/${this.state.repos}`)
            }
        }
    }

    componentWillReceiveProps(next) {
        this.setState({
            repos: next.match.params.rooms,
            isClicked: false
        })
        this.getRooms(`http://localhost:8727/room/${next.match.params.rooms}`)
    }

    async getRooms(url) {
        await axios.get(url).then((response) => { this.setState({ data: response.data, isClicked: true }) })
    }

    render() {
        return(
            <div className="container">{this.state.data}</div>
        )
    }
}

export default Chat;