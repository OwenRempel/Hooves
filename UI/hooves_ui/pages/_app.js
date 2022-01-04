import '../styles/globals.css'
import Header from '../Components/Header'
import Footer from '../Components/Footer'
import Nav from '../Components/Nav'
import Login from '../Components/Login'
import Router from 'next/router'
import { GetServerSideProps } from 'next'


function MyApp({ Component, pageProps, cookies }) {

  console.log(cookies);
  const auth = false;
  const loginCatch = async (e) =>{
    e.preventDefault();
    let builder = {};
    for (let i = 0; i < e.target.length; i++) {
      const item = e.target[i];
      if(item.type !== 'submit'){
        builder[item.name] = item.value;
      }
    }
    const res = await fetch('http://localhost/login', {
      method: 'POST',
      headers:{
        'Content-Type': '"application/x-form-urlencoded"'
      },
      body: JSON.stringify(builder)
    });
    const Response = await res.text();
    console.log(Response);
    Router.reload();
  };

  
  return (
  <>
  {!auth && <Login onSubmit={loginCatch}/>}

  {auth &&  <>
    <Header/>  
    <div className='MainContent'>
      <Nav />
      <div className='container'>
        <Component {...pageProps} />
      </div>
    </div>

    <Footer/>
    </>
  }
  
  </>
  
  );
}


export default MyApp
