import React, { useEffect, useState } from 'react'
import { Link,useNavigate } from 'react-router-dom'
import './addProduct.scss'
import axios from 'axios'

function AddProduct() {
    const [warning,setWarning]=useState('')
    const [product,setProduct]=useState({
      name:'',
      sku:'',
      price:'',
      productType:'DVD',
      size:'',
      height:'',
      width:'',
      length:'',
      weight:''
    })
    const navigate = useNavigate();

    const handleChange=(e)=>setProduct({...product,[e.target.name]:e.target.value});

    const handleSubmitProducts=async()=>{
        const newProduct = {...product};
        if(product.productType == 'DVD'){
            delete newProduct.height;
            delete newProduct.weight;
            delete newProduct.width;
            delete newProduct.length;
        }else if(product.productType == 'Furniture'){
            delete newProduct.size;
            delete newProduct.weight;
        }else if(product.productType == 'Book'){
            delete newProduct.height;
            delete newProduct.size;
            delete newProduct.width;
            delete newProduct.length;
        }else{
            setWarning('please make sure all feild a fille')
        }

        let bodyContent = JSON.stringify(newProduct);
        
        let reqOptions = {
          url: "https://bartleyc.000webhostapp.com/Controller/Product.controller.php",
          method: "POST",
          headers: {},
          data: bodyContent,
        }
        
        let response = await axios.request(reqOptions);

        if(response.data.status){
            navigate('/')
        }else{
            setWarning(response.data.message)
        }
    }

    useEffect(()=>{
        const timer = setTimeout(()=>{
            setWarning('')
        },3000)   
        return ()=>clearTimeout(timer);
    })

  return (<>
    <nav>
        <h1>Product Add</h1>
        <div className="links">
            <Link onClick={handleSubmitProducts}>Save</Link>
            <Link to='/'>Cancel</Link>
        </div>    
    </nav>
    <main>
        <form id='product_form'>
            {warning&&<p className='warning'>{warning}</p>}
            <div className='form_input'>
                <label htmlFor="sku">SKU</label>
                <input type="text" id='sku' name='sku' value={product.sku} onChange={handleChange}  required/>
            </div>
            <div className='form_input'>
                <label htmlFor="name">Name</label>
                <input type="text" autoCapitalize='on' name='name' id='name' value={product.name} onChange={handleChange} required />
            </div>
            <div className='form_input'>
                <label htmlFor="price">Price $</label>
                <input type="number" autoComplete='off' name='price' id='price' step=".01" value={product.price} onChange={handleChange} required />
            </div>
            <div className='form_input'>
                <label id='switch_label' htmlFor="productType">Type Switcher</label>
                <select name="productType" id="productType" onChange={handleChange}>
                    <option value="DVD" id='DVD'>DVD</option>
                    <option value="Furniture" id='Furniture'>Furniture</option>
                    <option value="Book" id='Book'>Book</option>
                </select>
            </div>
            {
                product.productType==='DVD'&&
                <div className='switch'>
                    <p>Please provide size in MB</p>
                    <div className='form_input'>
                        <label htmlFor="size">Size (MB)</label>
                        <input type="number" id='size' name='size' step=".0001" value={product.size} onChange={handleChange} required/>
                    </div>
                </div>
            }
            {
            product.productType==='Furniture'&&
                <div className='switch'>
                    <p>Please provide dimension in (HxWxL) format all in centimeter</p>
                    <div className='form_input'>
                        <label htmlFor="height">Height (CM)</label>
                        <input type="number" id='height'  name='height' step=".001" value={product.height} onChange={handleChange} required/>
                    </div>
                    <div className='form_input'>
                        <label htmlFor="width">Width (CM)</label>
                        <input type="number" id='width' step=".001" name='width' value={product.width} onChange={handleChange} required/>
                    </div>
                    <div className='form_input'>
                        <label htmlFor="length">Length (CM)</label>
                        <input type="number" id='length' step=".001" name='length' value={product.length} onChange={handleChange}  required/>
                    </div>
                </div>
            }
            {
                product.productType==='Book'&&
                <div className='switch'>
                    <p>Please provide weight in kilograms (Kg)</p>
                    <div className='form_input'>
                        <label htmlFor="weight">Weight (Kg)</label>
                        <input type="number" id='weight' name='weight' step=".0001" value={product.weight} onChange={handleChange}  required/>
                    </div>
                </div>
            }
        </form>
    </main>
    <footer>
      <h5>Scandiweb Test Assignment</h5>
    </footer>
    </>)
}

export default AddProduct