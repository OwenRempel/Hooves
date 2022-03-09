import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { formHandle } from "../../../lib/FormHandle";
import Form from "../../Form";



function GroupAdd() {
    const nav = useNavigate();
    const [FormData, setFormData] = useState({})
    useEffect(() => {
        fetch(process.env.REACT_APP_API_URL+'/group/info?token='+localStorage.getItem('Token'))
              .then(response => response.json())
              .then(result => {
                setFormData(result)
               
              });
      }, [])

    console.log(FormData)

    const  submitHandle = async (e) =>{
        e.preventDefault();
        const  res = await formHandle(FormData, e.target);
        if(res.success){
          console.log('Group Added successfully')
          e.target.reset()
          nav('/groups')
        }else{
          console.log(res)
        }
    }

    return(
        <>
            {FormData.form &&  <Form {...FormData} onSubmit={submitHandle}/> }
        </>
    )
}

export default GroupAdd