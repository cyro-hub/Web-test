import { BrowserRouter as Router,Routes,Route,Navigate } from "react-router-dom"
import Products from "./Pages/Products"
import AddProduct from "./Pages/AddProduct"

function App() {

  return (
    <Router>
      <Routes>
        <Route path='/' element={<Navigate replace to="/product" />}/>
        <Route path='/product' element={<Products/>}/>  
        <Route path='/add-product' element={<AddProduct/>}/>  
      </Routes>
    </Router>
  )
}

export default App
