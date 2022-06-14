import React, {useState,useEffect,createContext, useReducer} from "react"
import {ProductReducer} from "./productReducer"
import axios from "axios";
import AppURL from "../AppURL";
export const productContext = createContext();


const ProductContextProvider = props => {
    const [products , setProducts] = useState([]);
    
    useEffect(() => {
        const fetchUser = () => {
           
            axios.get(AppURL.ProductList).then(response=>{
                setProducts(response.data);
            })
          }
      
          fetchUser();
    
    }, [])
    
    
   if(products.length)   {
    return(
       
        <productContext.Provider value={{products}}>
           {props.children}
        </productContext.Provider>
        
    );
   }else{
       return<h1>Loading</h1>
   }
}



export default ProductContextProvider
