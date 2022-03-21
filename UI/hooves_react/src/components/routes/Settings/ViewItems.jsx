import React, { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom';
import Back from '../../Back'

function ViewItems() {
    const nav = useNavigate()
    const [ Items, setItems] = useState(false);

    useEffect(() => {
        fetch(process.env.REACT_APP_API_URL+'/settings/view-items/info?token='+localStorage.getItem('Token'))
              .then(response => response.json())
              .then(result => {
                setItems(result)
              })
      }, []);

    const itemsCatch = async (e) => {
        e.preventDefault()
       
        let FormItem = e.target
        let FormOut = {};
        for (let i = 0; i < FormItem.length; i++) {
            const item = FormItem[i]; 
            FormOut[item.name] = (item.checked ? true : false);
        }
        const token = localStorage.getItem('Token');
        FormOut['Token'] = token;
        const res = await fetch(process.env.REACT_APP_API_URL+'/settings/view-items/', {
            method: 'POST',
            headers:{
            'Content-Type': '"application/x-form-urlencoded"'
            },
            body: JSON.stringify(FormOut)
        });
        
        const Response = await res.json();
        if(Response.success){
            nav('/settings')
        }
    }
    const ItemsView = (props) =>{
        const { data } = props
        return(
            <form method='post' onSubmit={itemsCatch}>
                <input type='hidden' name="SettingsMod"/>
                {Object.keys(data).map((i, key)=>(
                    <div key={key} className='viewItems'>
                        <input type='checkbox' name={i} defaultChecked={data[i].value}/>
                        <p>{data[i].name}</p> 
                    </div>
                ))}
                <button className='btn' type='submit'>Update</button>
            </form>
        )
    }
    return (
        <>
        <Back link='/settings'/>
        {Items && 
            <>
                <h3>Form Items</h3>
                <ItemsView data={Items}/>
            </>
        }
        </>
    )
}

export default ViewItems