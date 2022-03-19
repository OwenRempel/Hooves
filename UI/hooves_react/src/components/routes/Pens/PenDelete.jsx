import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import Back from "../../Back";
function PenDelete() {


    //TODO: Add system to move any cows from pen being deleted

    

    const { ID } = useParams();
    const nav = useNavigate();
    const [Pens, setPens] = useState({})

    useEffect(() => {
        fetch(process.env.REACT_APP_API_URL+'/pens?token='+localStorage.getItem('Token'))
        .then(response => response.json())
        .then(result => {
            setPens(result)
        });
    }, [])
    
    const del = (e) => {
        e.preventDefault()
        let move = e.target[0].value
        fetch(process.env.REACT_APP_API_URL+'/pens/'+ID+'?move='+move+'&token='+localStorage.getItem('Token'),{
            method:'DELETE'
        })
        .then(response => response.json())
        .then(result => {
            if(result.success){
                nav('/settings/pens');
            }else{
                console.log(result);
            }
        });
        
    }
    const no = () => {
        nav('/settings/pens');
    }
    const SelPen = (parms) =>{
        const { data } = parms
        console.log(data)
        if(data.Data){
            return(
                <select name="pen">
                    {data.Data.map((i, key)=>{
                        if(i.ID !== ID){
                            return <option key={key} value={i.ID}>{i.Name}</option>
                        }else{
                            return false
                        }
                    })}
                </select>
            )
        }
        
        return false
    }
    return (
        <div>
            <Back link={`/settings/pens`} />
            <div className="delWrap">
                <h2>Delete</h2>
                <p>Are you sure you want to delete this Pen?</p>
                <form method="post" onSubmit={del}>
                <SelPen data={Pens}/>
                <br></br>
                <button className="btn yes-btn" type="submit">Yes</button>
                <button className="btn no-btn" onClick={no}>No</button>
                </form>
                
            </div>
            
        </div>
    )
}

export default PenDelete