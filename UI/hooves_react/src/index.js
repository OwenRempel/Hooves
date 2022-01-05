import { render } from "react-dom";
import {
  BrowserRouter,
  Routes,
  Route,
  Outlet,
  Link
} from "react-router-dom";
import React, { useState } from 'react';
import Login from "./components/Login";
import Header from './components/Header';
import Nav from './components/Nav';
import Footer from './components/Footer';
import App from "./App";
import Home from "./components/routes/Home";
import Companies from './components/routes/Companies';
import NotFound from "./components/routes/NotFound";
import './App.css'

const rootElement = document.getElementById("root");

//querys the api to see if the token is valid
const checkToken = async (Token) => {
  const checkToken = await fetch('http://localhost/token', {
    method:"POST",
    headers:{
      'Content-Type': '"application/x-form-urlencoded"'
    },
    body:JSON.stringify({'Token':Token})
  });
  const tokenData = await checkToken.json();
  if(tokenData.sucess && tokenData.Token){
    let time = (Math.round(new Date() / 1000) + (60*24*3))
    localStorage.setItem('TokenExpire', time);
    setAuth(true);
  }else{
    setAuth(false);
  }
  console.log('checked Token');
}
//logic for when the login form is submitted
const loginCatch = async (e) =>{
  e.preventDefault();
  let target = e.target;
  let formItems = {};
  for (let i = 0; i < target.length; i++) {
    const item = target[i];
    if(item.type !== 'submit'){
      formItems[item.name] = item.value;
    }
  }

  const checkAuth = await fetch('http://localhost/login', {
    method:"POST",
    headers:{
      'Content-Type': '"application/x-form-urlencoded"'
    },
    body:JSON.stringify(formItems)
  })
  const checkAuthData = await checkAuth.json();
  let time = (Math.round(new Date() / 1000) + (60*24*3))
  if(checkAuthData.Token && (checkAuthData.sucess || checkAuthData.info)){
    localStorage.setItem('Token', checkAuthData.Token);
    localStorage.setItem('TokenExpire', time);
    setAuth(true);
  }else if(checkAuthData.error){
    setFormError({"error":checkAuthData.error});
  }
}
const LoginCheck = () => {
  //use state for updating the page based on auth
  const [auth, setAuth] = useState(false);
  //state for showing user a error message for login input
  const [formError, setFormError] = useState({'Error':false});
  //checks to see if the token is set in local storage
  if(localStorage.getItem('Token') && localStorage.getItem('TokenExpire')){
    //see if the token has expired
    if(parseInt(localStorage.getItem('TokenExpire')) < Math.round(new Date() / 1000)){
      checkToken(localStorage.getItem('Token'));
    }else{
      if(!auth){
        setAuth(true)
      }
    }
  }
}


LoginCheck();

render(
  <BrowserRouter>
    {auth === false &&
      <Login onSubmit={loginCatch} error={formError.Error}/>
    }
    {auth === true &&
      <div className='wraper'>
        <Header/>
        <div className='MainContent'>
          <Nav/>
          <div  className='container'>
            <Routes>
              <Route path="/" element={<Home />}>
                <Route path="companies" element={<Companies />} />
                <Route path='*' element={<NotFound />} />
              </Route>
            </Routes>
          </div>
        </div>
        <Footer/>
      </div>
    }
  </BrowserRouter>,
  rootElement
);