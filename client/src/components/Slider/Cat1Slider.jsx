import React, {useContext , useEffect , useState} from "react"
import Slider from "react-slick";
import AppURL from '../../AppURL';
import axios from 'axios';

const Cat1Slider = (props) => {

    const [itemData,setItemData] = useState({
        ProductData:[],
    });

    useEffect(() => {
        const fetchImages = () => {
            axios.get(AppURL.MegaSlider(props.code)).then(response=>{
                console.log(props.code);
                setItemData(values => ({...values,ProductData: response.data}));
                console.log(response.data);
            }).catch(error=>{
                
            });
        }
      
        fetchImages();
    
    }, []);

    const sliderData = itemData.ProductData.map(slide=>{
        return(
            <div>
                
                    <img src={AppURL.Images+"slider"+props.code+"/"+slide} className="card-img-top" alt="..." />
                    
            </div>
        )
    })



    const settings = {
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        autoplay: true,
        speed: 2000,
        autoplaySpeed: 2000,
        slidesToScroll: 1
      };

    return (
        <div>
            <Slider {...settings}>
          {sliderData}
        </Slider>
        </div>
    )
}

export default Cat1Slider
