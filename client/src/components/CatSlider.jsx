import React from 'react'
import Slider from "react-slick";
import AppURL from '../AppURL';

const CatSlider = () => {

    const settings = {
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1
      };

    return (
        <div>
            <Slider {...settings}>
          <div>
                
                    <img src={AppURL.Images+'cat-img-1.jpg'} class="card-img-top" alt="..." />
               
          </div>
          {/* End of Slider Item */}

          <div>
                
                    <img src={AppURL.Images+'cat-img-1.jpg'} class="card-img-top" alt="..." />
               
          </div>
          {/* End of Slider Item */}

          <div>
                
                    <img src={AppURL.Images+'cat-img-1.jpg'} class="card-img-top" alt="..." />
               
          </div>
          {/* End of Slider Item */}

          
          
          
          
        </Slider>
        </div>
    )
}

export default CatSlider
