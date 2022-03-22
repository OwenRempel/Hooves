import Back from "../../Back";
import { useParams, useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import Form from "../../Form";
import { formHandle } from "../../../lib/FormHandle";

function AddMedicine() {
    const nav = useNavigate();
    const { ID } = useParams();
    const [formData, setFormData] = useState({});
    useEffect(() => {
      fetch(process.env.REACT_APP_API_URL+'/medical/info', {
        headers:{
          'Authorization': 'Bearer '+localStorage.getItem('Token')
        }
      })
            .then(response => response.json())
            .then(result => {
              setFormData(result)
            });
    }, [])
    const returnFormData = async (e) =>{
        e.preventDefault();
        e.preventDefault();
        const  res = await formHandle(formData, e.target, 'POST', ID);
        console.log(res)
        if(res.success){
            nav(`/cows/${ID}`)
        }
    }
  return(
      <>
      <Back link={`/cows/${ID}`}/>
      {formData.form && <Form onSubmit={returnFormData}  {...formData} />}
      </>
  );
}

export default AddMedicine;
