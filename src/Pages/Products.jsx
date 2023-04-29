import React, { useEffect, useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import './products.scss'
import axios from 'axios'

function Products() {
  const [deleteList,setDeleteList]=useState([])
  const [productList,setProductsList]=useState([])

  const navigate = useNavigate();

  useEffect(()=>{
    const getProduct=async()=>{
      let reqOptions = {
        url: "https://bartleyc.000webhostapp.com/Controller/Product.controller.php",
        method: "GET",
        headers: {},
      }
      
      let response = await axios.request(reqOptions);
      setProductsList(response.data);
    }
    getProduct();
  },[])

const handleDeleteProducts = async()=>{
   let bodyContent = JSON.stringify(deleteList);
   
   let reqOptions = {
     url: "https://bartleyc.000webhostapp.com/Controller/Delete.product.controller.php",
     method: "POST",
     headers: {},
     data: bodyContent,
   }
   
   let response = await axios.request(reqOptions);

   if(!response.data[0]) return;

   navigate('/');
     
}

  return (
    <>
    <nav>
        <h1>Product List</h1>
        <div className="links">
            <Link to='/add-product'>Add</Link>
            <Link id="delete-product-button" onClick={handleDeleteProducts} >Mass Delete</Link>
        </div>    
    </nav>
    <main>
      {
        productList?.map(({name,productType,sku,price,unit,id})=><div key={id} className='card'>
                                        <input type="checkbox" 
                                               onClick={(e)=>{
                                                if(e.target.checked){
                                                  setDeleteList([...deleteList,id])
                                                }else{
                                                  setDeleteList(deleteList.filter(productItem=>productItem!==id))
                                                }
                                               }} 
                                               className='delete-checkbox' />
                                        <h4>{sku}</h4>
                                        <h4>{name}</h4>
                                        <h4>${price}</h4>
                                        <h4>
                                          {
                                            productType=='Furniture'?'Dimension :':productType=='Book'?"weight :":"size :"
                                          }
                                          {unit}
                                        </h4>
                                    </div>)
      }
    </main>
    <footer>
      <h5>Scandiweb Test Assignment</h5>
    </footer>
    </>
  )
}

export default Products