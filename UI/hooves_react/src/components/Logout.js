import { useNavigate } from "react-router-dom"


function Logout() {
    const navigate = useNavigate();
   fetch('http://localhost/logout',{
       method:'POST',
       headers:{
        'Content-Type': '"application/x-form-urlencoded"'
      },
      body:JSON.stringify({'Token':localStorage.getItem('Token')})
   }).then(response => response.json())
   .then(result => {
    console.log(result)
    localStorage.removeItem('Token');
    localStorage.removeItem('TokenExpire');
    navigate('/');
   });



   return(
    <div style={{
        display:'flex',
        alignItems:'center',
        justifyContent:'center',
        height:'100%'
   }}>
    <h1>Loging You Out</h1>
    </div>
   )
}

export default Logout
