import React from 'react'
import AppURL from '../../AppURL';
import Cat1Slider from './Cat1Slider';

const MCatSlider = () => {
    return (
        <>
            <section className="pt-5">
          <header className="text-center">
            <p className="small text-muted small text-uppercase mb-1">Carefully created collections</p>
            <h2 className="h5 text-uppercase mb-4">Browse our categories</h2>
          </header>
          <div className="row">
            {/* <div className="col-md-4 mb-4 mb-md-0"><a className="category-item" href="shop.html"><img className="img-fluid" src="img/cat-img-1.jpg" alt="" /><strong className="category-item-title">Clothes</strong></a></div> */}
            <div className="col-md-4 mb-4 mb-md-0"><a className="category-item" href="shop.html"><Cat1Slider code="1" /><strong className="category-item-title">Clothes</strong></a></div>
            <div className="col-md-4 mb-4 mb-md-0"><a className="category-item mb-4" href="shop.html"><Cat1Slider code="2" /><strong className="category-item-title">Shoes</strong></a><a className="category-item" href="shop.html"><Cat1Slider code="3" /><strong className="category-item-title">Watches</strong></a></div>
            <div className="col-md-4"><a className="category-item" href="shop.html"><Cat1Slider code="4" /><strong className="category-item-title">Electronics</strong></a></div>
          </div>
            </section>  
        </>
    )
}

export default MCatSlider
