import Back from "../../Back";
import { useParams, useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";
import { formHandle } from "../../../lib/FormHandle";
import Form from "../../Form";

function EditWeight() {
    const { Cow, ID } = useParams();
    const [formData, setFormData] = useState({});
    const nav = useNavigate();
    useEffect(() => {
      fetch(process.env.REACT_APP_API_URL+'/weight/info/'+ID+'?token='+localStorage.getItem('Token'))
            .then(response => response.json())
            .then(result => {
              setFormData(result)
            });
    }, [ID])
    const returnFormData = async (e) => {
        e.preventDefault();
        const  res = await formHandle(formData, e.target, 'PUT');
        if(res.success){
            nav('/cows/'+Cow);
        }
    }
    
    return (
        <div>
            <Back link={`/cows/${Cow}`} />
            {formData.form && <Form onSubmit={returnFormData}  {...formData} />}
        </div>
    )
}

export default EditWeight;
