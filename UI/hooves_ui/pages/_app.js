import '../styles/globals.css'
import Header from '../Components/Header'
import Footer from '../Components/Footer'
import Nav from '../Components/Nav'
import Login from '../Components/Login'

function MyApp({ Component, pageProps }) {
  const auth = true;
  return (
  <>
  {!auth && <Login/>}

  {auth &&  <>
    <Header/>  
    <div className='MainContent'>
      <Nav />
      <Component {...pageProps} />
    </div>

    <Footer/>
    </>
  }
  
  </>
  
  );
}

export default MyApp
