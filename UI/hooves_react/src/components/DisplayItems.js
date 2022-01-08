
function DisplayItems({ data }) {
    let newArray = [];
    const { Data, Info } = data
    for(let item in Info){
        newArray.push({'name':Info[item], 'value':Data[0][item]})
    }
    
    
    return (
        <div className="DisplayWrapper">
            { newArray.map((item, i) => (
                <div key={i} className="DisplayItem"><span>{item.name}</span><span>{item.value}</span></div>
            ))}
        </div>
    )
}

export default DisplayItems
