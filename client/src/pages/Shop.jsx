import React, { useState, useEffect, useContext } from 'react'
import { productContext } from "../global/productContext"
import { cartContext } from "../global/cartContext";
import AppURL from '../AppURL';
import axios from 'axios';

const Shop = () => {
    const [cat , setCat] = useState([]);
    const {products} = useContext(productContext);
    const {dispatch} = useContext(cartContext);

    useEffect(() => {
        const fetchCats = () => {
            axios.get(AppURL.Categories).then(response=>{
                // console.log(response.data);
                setCat(response.data);
                console.dir(response.data);
            }).catch(error=>{
                
            });
            
        }
        fetchCats();
    }, [])

    if(!cat){
      return(
        <>
        <h4>Loading</h4>
        </>
      )
    }else{
      const brands = cat.map((cats,key)=>{
        if(cats.dept==2){
        return (
          <li className="mb-2"><a className="reset-anchor" href="#">{cats.cname}</a></li>
        )}
      });

      const names = cat.map((cats,key)=>{
        if(cats.dept!==2){
        return (
          <li className="mb-2"><a className="reset-anchor" href="#">{cats.cname}</a></li>
        )}
      });

      const ProductList = products;
      const userView = ProductList.map((product,key)=>{
        return(
          <>
            <div className="col-lg-4 col-sm-6">
                    <div className="product text-center">
                      <div className="mb-3 position-relative">
                        <div className="badge text-white badge-"></div><a className="d-block" href="detail.html"><img className="img-fluid w-100" src="img/product-1.jpg" alt="..." /></a>
                        <div className="product-overlay">
                          <ul className="mb-0 list-inline">
                            <li className="list-inline-item m-0 p-0"><a className="btn btn-sm btn-outline-dark" href="#"><i className="far fa-heart"></i></a></li>
                            <li className="list-inline-item m-0 p-0"><a className="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li className="list-inline-item mr-0"><a className="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i className="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a className="reset-anchor" href="detail.html">Kui Ye Chen’s AirPods</a></h6>
                      <p className="small text-muted">$250</p>
                    </div>
                  </div>
          </>
        )
      })

      return (
        <>
    <div className="page-holder">
      <div className="container">
      
        <section className="py-5 bg-light">
          <div className="container">
            <div className="row px-4 px-lg-5 py-lg-4 align-items-center">
              <div className="col-lg-6">
                <h1 className="h2 text-uppercase mb-0">Shop</h1>
              </div>
              <div className="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                  <ol className="breadcrumb justify-content-lg-end mb-0 px-0">
                    <li className="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li className="breadcrumb-item active" aria-current="page">Shop</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </section>
        <section className="py-5">
          <div className="container p-0">
            <div className="row">
              
              <div className="col-lg-3 order-2 order-lg-1">
                <h5 className="text-uppercase mb-4">Categories</h5>
                <div className="py-2 px-4 bg-dark text-white mb-3"><strong className="small text-uppercase font-weight-bold">Fashion &amp; Acc</strong></div>
                <ul className="list-unstyled small text-muted pl-lg-4 font-weight-normal">
                  {brands}
                </ul>
                <div className="py-2 px-4 bg-light mb-3"><strong className="small text-uppercase font-weight-bold">Health &amp; Beauty</strong></div>
                <ul className="list-unstyled small text-muted pl-lg-4 font-weight-normal">
                  {names}
                </ul>
                <div className="py-2 px-4 bg-light mb-3"><strong className="small text-uppercase font-weight-bold">Electronics</strong></div>
                <ul className="list-unstyled small text-muted pl-lg-4 font-weight-normal mb-5">
                  <li className="mb-2"><a className="reset-anchor" href="#">Electronics</a></li>
                  <li className="mb-2"><a className="reset-anchor" href="#">USB Flash drives</a></li>
                  <li className="mb-2"><a className="reset-anchor" href="#">Headphones</a></li>
                  <li className="mb-2"><a className="reset-anchor" href="#">Portable speakers</a></li>
                  <li className="mb-2"><a className="reset-anchor" href="#">Cell Phone bluetooth headsets</a></li>
                  <li className="mb-2"><a className="reset-anchor" href="#">Keyboards</a></li>
                </ul>
                
              </div>
              
              <div className="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
                <div className="row mb-3 align-items-center">
                  <div className="col-lg-6 mb-2 mb-lg-0">
                    <p className="text-small text-muted mb-0">Showing 1–12 of 53 results</p>
                  </div>
                  <div className="col-lg-6">
                    <ul className="list-inline d-flex align-items-center justify-content-lg-end mb-0">
                      <li className="list-inline-item text-muted mr-3"><a className="reset-anchor p-0" href="#"><i className="fas fa-th-large"></i></a></li>
                      <li className="list-inline-item text-muted mr-3"><a className="reset-anchor p-0" href="#"><i className="fas fa-th"></i></a></li>
                      <li className="list-inline-item">
                        <select className="selectpicker ml-auto" name="sorting" data-width="200" data-style="bs-select-form-control" data-title="Default sorting">
                          <option value="default">Default sorting</option>
                          <option value="popularity">Popularity</option>
                          <option value="low-high">Price: Low to High</option>
                          <option value="high-low">Price: High to Low</option>
                        </select>
                      </li>
                    </ul>
                  </div>
                </div>
                <div className="row">
                  {userView}
                </div>
                
                <nav aria-label="Page navigation example">
                  <ul className="pagination justify-content-center justify-content-lg-end">
                    <li className="page-item"><a className="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                    <li className="page-item active"><a className="page-link" href="#">1</a></li>
                    <li className="page-item"><a className="page-link" href="#">2</a></li>
                    <li className="page-item"><a className="page-link" href="#">3</a></li>
                    <li className="page-item"><a className="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </section>
      </div>
            
    </div>
        </>
    )}
}

export default Shop
