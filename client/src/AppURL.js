class AppURL{
    static BaseURL = "http://127.0.0.1:8000/api/";
    static ProductList = this.BaseURL + "products";
    static Images = "http://localhost:3000/img/";

    static ProductDetails(code){
        return this.BaseURL+"productdetails/"+code;
    }

    static RelatedProducts(code){
        return this.BaseURL+"relatedProduct/"+code;
    }

    static storeOrder = this.BaseURL + "storeOrder/";
    static UserLogin = this.BaseURL+"login";
    static UserRegister = this.BaseURL+"register";
    static UserData = this.BaseURL+"user"
    static Categories = this.BaseURL+"shop"
    
}

export default AppURL;