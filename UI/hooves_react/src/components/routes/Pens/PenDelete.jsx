import { useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import Back from "../../Back";
function PenDelete() {
    const { ID } = useParams();
    const nav = useNavigate();
    
    const [Delete, setDelete] = useState(false);
    
    if(Delete === true){
        fetch(process.env.REACT_APP_API_URL+'/pen/'+ID+'?token='+localStorage.getItem('Token'),{
            method:'DELETE'
        })
        .then(response => response.json())
        .then(result => {
            if(result.success){
                nav('/settings/pens');
            }
        });
    }
    const del = () => {
        setDelete(true);
    }
    const no = () => {
        nav('/settings/pens');
    }
    return (
        <div>
            <Back link={`/settings/pens`} />
            <div className="delWrap">
                <h2>Delete</h2>
                <p>Are you sure you want to delete this Pen?</p>
                <button className="btn yes-btn" onClick={del}>Yes</button>
                <button className="btn no-btn" onClick={no}>No</button>
            </div>
            
        </div>
    )
}

export default PenDelete