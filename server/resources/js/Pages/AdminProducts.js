import React from 'react';
import {Inertia , InertiaLink} from '@inertiajs/inertia-react';

const AdminProducts =(props)=>{
return(
<>
<table className="table table-hover">
                                        <thead>
                                          <tr>
                                            <th style={{width: "3%"}}>Id</th>
                                            <th style={{width: "20%"}}>Name</th>
                                            <th style={{width: "10%"}}>Price</th>
                                            <th style={{width: "30%"}}>Action</th>
                                            <th style={{width: "37%"}}>Img</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        {props.pro.map(product=>{
                                          return(
                                              <tr id={product.id}>
                                                  <td>{product.id}</td>
                                                  <td>{product.name}</td>
                                                  <td>{product.price}</td>
                                                  <td>
                                                    <button  className="btn-small btn-primary mr-1 aButton"><InertiaLink href={product.edit_url}>Edit</InertiaLink></button>
                                                    {/* <button onClick={()=>{const id = product.id; delProduct(id);}} className="btn-small btn-danger">Delete</button> */}
                                                    <button onClick={()=>{props.deleteRoute(product.id)}} className="btn-small btn-danger">Delete</button>
                                                  </td>
                                                  <td><img className="w-25" src={base_url +'/storage/img/' +product.ipath} alt="..." /></td>
                                              </tr>
                                          )
                                        })}
                                          
                                        </tbody>
                                      </table>
</>
)}

export default AdminProducts