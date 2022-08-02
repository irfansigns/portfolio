import React,{useEffect} from 'react';
import {Inertia , InertiaLink} from '@inertiajs/inertia-react';

const AdminProducts =(props)=>{
    useEffect(()=>{
        <>
            axios.post(route('updateUser'),formData).then(respond=>{
                    // console.log(respond);
                
            });
        </>
    });

    return(
        <>
        <h2>Welcome to Products page {props.category-1}</h2>
        </>
    )
}

export default AdminProducts