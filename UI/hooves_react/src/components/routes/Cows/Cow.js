import { useParams } from 'react-router-dom';
import { useState, useEffect } from 'react';
import DisplayItems from '../../DisplayItems';
import Back from '../../Back'



function Cow() {
    
    const { ID } = useParams();
    const [Cow, setCow] = useState({});
    useEffect(() => {
      fetch('http://localhost/cattle/'+ID+'?token='+localStorage.getItem('Token'))
            .then(response => response.json())
            .then(result => {
              setCow(result)
              
            })
    }, [ID]);

    return (
        <div>
            <Back link='/cows' />
            {Cow.Data &&
                <DisplayItems data={Cow}/>
            }        
        </div>
    )
}

export default Cow
