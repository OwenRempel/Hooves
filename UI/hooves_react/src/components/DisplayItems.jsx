import Table from "./Table/Table";
import { useParams } from "react-router-dom";
function DisplayItems({ data }) {
    const { ID } = useParams();
    let newArray = [];
    const { Data, Info, Sub } = data
    for(let item in Info){
        newArray.push({'name':Info[item], 'value':Data[0][item]})
    }
    
    return (
        <div className="DisplayWrapper">
            <div className="cowInfo">
                { newArray.map((item, i) => (
                    <div key={i} className="DisplayItem"><span>{item.name}</span><span>{item.value}</span></div>
                ))}
            </div>
            
            <div className="subInfo">
                {Object.keys(Sub).map((key, i) =>(
                    <span key={i}>
                        <h2>{key.charAt(0).toUpperCase() + key.slice(1)}</h2>
                        <Table stick={false} table={Sub[key]} UrlKey={
                            [
                                {
                                    title:'Edit',
                                    link:`/cows/${key}/edit/${ID}/`
                                },
                                {
                                    title:'Delete',
                                    link:`/cows/${key}/Delete/${ID}/`
                                }
                            ]
                            }/> 
                       
                    </span>
                ))}
            </div>
            
        </div>
    )
}

export default DisplayItems
