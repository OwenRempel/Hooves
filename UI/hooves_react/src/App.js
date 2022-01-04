import { Outlet, Link } from "react-router-dom";
import Login from "./components/Login";
import './App.css';

export default function App() {
    let auth = false;
    if(localStorage.getItem('token') && localStorage.getItem('tokenExpire')){
      
    }


  const loginCatch = (e) =>{
    e.preventDefault();
    
  }
  
  return (
    <div>
      {!auth &&
        <Login onSubmit={loginCatch}/>
      }
      {auth &&
        <>
          <h1>Hooves</h1>
          <nav
            style={{
              borderBottom: "solid 1px",
              paddingBottom: "1rem"
            }}
          >
            <Link to="/invoices">Invoices</Link> |{" "}
            <Link to="/expenses">Expenses</Link>
          </nav>
          <Outlet />
      </>
      }
    </div>
   
  );
}