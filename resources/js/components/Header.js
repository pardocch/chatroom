// Header.js
import React, {Component} from 'react';
import { Router, Route } from 'react-router';
import { Link } from 'react-router-dom';

// class Header extends Component
// {
//     render() {
//         return(
// 			<div className="container">
//                 <div className="container-fluid">
//                     <h1><Link to="/">ChatRoom</Link></h1>
//                 </div>
//                 {this.props.children}
//             </div>
//         )
//     }
// }
const Header = (props) => (
    <div className="container">
        <div className="container-fluid">
            <h1><Link to="/">ChatRoom</Link></h1>
        </div>
         {props.children}
    </div>
)

// Header.propTypes = {
//     children: React.propTypes.object,
// };

export default Header;