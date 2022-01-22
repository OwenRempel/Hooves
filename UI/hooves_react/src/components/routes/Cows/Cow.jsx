import { useParams, Link } from 'react-router-dom';
import { useState, useEffect} from 'react';

import DisplayItems from '../../DisplayItems';
import Back from '../../Back'



function Cow() {
    
    const { ID } = useParams();
    const [Cow, setCow] = useState({});
    useEffect(() => {
      fetch(process.env.REACT_APP_API_URL+'/cattle/'+ID+'?token='+localStorage.getItem('Token'))
            .then(response => response.json())
            .then(result => {
              setCow(result)
              
            })
    }, [ID]);
    return (
        <div>
           
            {Cow.Data &&
            <div className='viewWrap'>
                <div className="cowMenu">
                    <Back link='/cows' />
                    <Link to={`/cows/update/${ID}`}>
                        <button className='btn'>Edit</button>
                    </Link>
                    <Link to={`/cows/weight/add/${ID}`}>
                        <button className='btn'>Add Weight</button>
                    </Link>
                    <Link to={`/cows/medical/add/${ID}`}>
                        <button className='btn'>Add Medicine</button>
                    </Link>
                    <Link to={`/cows/delete/${ID}`}>
                        <button className='btn no-btn'>Delete</button>
                    </Link>
                </div>
                <DisplayItems data={Cow}/>
            </div>
            }        
        </div>
    )
}

export default Cow
