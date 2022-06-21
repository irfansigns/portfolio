import React, {useContext , useEffect , useState} from "react"
import { productContext } from "../global/productContext"
import { cartContext } from "../global/cartContext";
import AppURL from '../AppURL';
import axios from 'axios';
import { Link } from 'react-router-dom'


const HomePage1 = () => {
    // const [HomeData,setHomeData] = useState({
    //     ProductData:[]
    // });

    const {products} = useContext(productContext);
    const {dispatch} = useContext(cartContext);
    // useEffect(() => {
    //     const fetchProducts = () => {
    //         axios.get(AppURL.ProductList).then(response=>{
    //             // console.log(response.data);
    //             setHomeData(values => ({...values,ProductData: response.data}));
    //         }).catch(error=>{
                
    //         });
            
    //     }
      
    //     fetchProducts();
    
    // }, [])
      
    const ProductList = products;
    const userView = ProductList.map((product,key)=>{
        return(
            <div className="col-xl-3 col-lg-4 col-sm-6" key={product.id}>
                <div className="product text-center">
                <div className="position-relative mb-3">
                    <div className="badge text-white badge-"></div><Link className="d-block" to={"/details/"+product.id}><img className="img-fluid w-100" src={AppURL.Images+product.i_path} alt="..." /></Link>
                    
                    <div className="product-overlay">
                    <ul className="mb-0 list-inline">
                        {/* <li className="list-inline-item m-0 p-0"><Link className="btn btn-sm btn-outline-dark" href={product.detail_url}><i className="far fa-heart"></i></Link></li> */}
                        {/* <li className="list-inline-item m-0 p-0"><a className="btn btn-sm btn-dark" href="cart.html">{product.quantity}</a></li> */}
                        {/* <li className="list-inline-item mr-0"><button className="btn btn-sm btn-outline-dark" onClick={()=>{const id = product.id; addToCart(id);}}  ><i className="fas fa-shopping-cart"><span className="ml-1">Add to Cart</span></i></button></li> */}
                        <li className="list-inline-item mr-0"><button onClick={() => dispatch({type: 'ADD_TO_CART', id: product.id, products})} className="btn btn-sm btn-outline-dark"><i className="fas fa-shopping-cart"><span className="ml-1">Add to Cart</span></i></button></li>
                    </ul>
                    </div>
                </div>
                <h6> <a className="reset-anchor" to="detail.html">{product.pname}</a></h6>
                <p className="small text-muted">${product.price}</p>
                {/* <button className="btn btn-small"><a href={product.edit_url}>Edit</a></button> */}
                </div>
            </div>
            )
    })
    return (
        <div className="container">
        <section className="pt-5">
          <header className="text-center">
            <p className="small text-muted small text-uppercase mb-1">Carefully created collections</p>
            <h2 className="h5 text-uppercase mb-4">Browse our categories</h2>
          </header>
          <div className="row">
            {/* <div className="col-md-4 mb-4 mb-md-0"><a className="category-item" href="shop.html"><img className="img-fluid" src="img/cat-img-1.jpg" alt="" /><strong className="category-item-title">Clothes</strong></a></div> */}
            <div className="col-md-4 mb-4 mb-md-0"><a className="category-item" href="shop.html"><img className="img-fluid" src={AppURL.Images+'cat-img-1.jpg'} alt="" /><strong className="category-item-title">Clothes</strong></a></div>
            <div className="col-md-4 mb-4 mb-md-0"><a className="category-item mb-4" href="shop.html"><img className="img-fluid" src={AppURL.Images+'cat-img-2.jpg'} alt="" /><strong className="category-item-title">Shoes</strong></a><a className="category-item" href="shop.html"><img className="img-fluid" src={AppURL.Images+'cat-img-3.jpg'} alt="" /><strong className="category-item-title">Watches</strong></a></div>
            <div className="col-md-4"><a className="category-item" href="shop.html"><img className="img-fluid" src={AppURL.Images+'cat-img-4.jpg'} alt="" /><strong className="category-item-title">Electronics</strong></a></div>
          </div>
        </section>   
        <section className="py-5">
        <header>
            <p className="small text-muted small text-uppercase mb-1">Made the hard way</p>
            <h2 className="h5 text-uppercase mb-4">Top trending products</h2>
            </header>
        <div className="row">
            
            
            {userView}
            
        </div>
        </section>
        </div>
    )
    
}

export default HomePage1
