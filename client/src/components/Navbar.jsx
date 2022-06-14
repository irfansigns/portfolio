import React, {useContext , useState } from 'react'
import {Link, Redirect} from "react-router-dom";
import App from '../App';
import { cartContext } from "../global/cartContext"
import AppURL from '../AppURL';
const Navbar =()=>{

  const {dispatch,shoppingCart,user} = useContext(cartContext);
  const [logout,setLogout] = useState(false);
  const logoutHandler = () => {
    setLogout(true);
  }

  if(logout){
    window.location.href = '/';
  }
    return(
        <>
            <header className="header bg-white">
          <div className="container px-0 px-lg-3">
            <nav className="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a className="navbar-brand" href="index.html"><span className="font-weight-bold text-uppercase text-dark">Replica Lounge</span></a>
              <button className="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span className="navbar-toggler-icon"></span></button>
              <div className="collapse navbar-collapse" id="navbarSupportedContent">
                <ul className="navbar-nav mr-auto">
                  <li className="nav-item">
                    <Link className="nav-link active" to="/">Home</Link>
                  </li>
                  <li className="nav-item">
                  <Link className="nav-link" to="/cart">Cart</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/shop">Shop</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/profile">Profile</Link>
                  </li>
                  <li className="nav-item dropdown"><a className="nav-link dropdown-toggle" id="pagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                    <div className="dropdown-menu mt-3" aria-labelledby="pagesDropdown"><Link className="dropdown-item border-0 transition-link" method="post" href="/logout">Logout</Link><a className="dropdown-item border-0 transition-link" href="shop.html">Category</a><a className="dropdown-item border-0 transition-link" href="detail.html">Product detail</a><a className="dropdown-item border-0 transition-link" href="cart.html">Shopping cart</a><a className="dropdown-item border-0 transition-link" href="checkout.html">Checkout</a></div>
                  </li>
                </ul>
                <ul className="navbar-nav ml-auto">               
                 
                  <li className="nav-item"><Link className="nav-link" href={AppURL + '/product/cart'}> <i className="fas fa-dolly-flatbed mr-1 text-gray"></i><small className="text-gray" id="cart"> ({shoppingCart.length})</small></Link></li>
                  {user?<li className="nav-item"><Link className="nav-link" onClick={logoutHandler}> <i className="fas fa-user-alt mr-1 text-gray"></i>Logout</Link></li>:
                  <li className="nav-item"><Link className="nav-link" method="get" to="/login"> <i className="fas fa-user-alt mr-1 text-gray"></i>Login</Link></li>
                  }
                  
                  
                  

{/* <li className="nav-item"><Link className="nav-link" method="post" href="#"> <i className="fas fa-user-alt mr-1 text-gray"></i>Logout</Link></li> */}

                </ul>
              </div>
            </nav>
          </div>
        </header>
        </>
    )
}

export default Navbar
